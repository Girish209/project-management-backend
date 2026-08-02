<?php

namespace App\Modules\Organizations\Actions;

use App\Modules\Organizations\DTOs\StoreOrganizationMemberData;
use App\Modules\Organizations\Contracts\OrganizationMemberRepositoryInterface;
use App\Modules\Organizations\Models\OrganizationMember;
use App\Modules\Organizations\Models\OrganizationInvitation;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

final class CreateOrganizationMemberAction
{
    public function __construct(private OrganizationMemberRepositoryInterface $members)
    {
    }

    public function execute(StoreOrganizationMemberData $data, string $organizationId): OrganizationMember
    {
        if (User::query()->where('email', $data->email)->exists()) {
            throw ValidationException::withMessages([
                'email' => 'This email is already used.',
            ]);
        }

        [$member, $token] = DB::transaction(function () use ($data, $organizationId): array {
            $user = User::query()->create([
                'first_name' => $data->firstName,
                'last_name' => $data->lastName,
                'email' => $data->email,
                // The user sets their real password after accepting the invitation.
                'password' => Str::password(64),
            ]);

            $member = $this->members->create([
                ...$data->toMemberAttributes(),
                'organization_id' => $organizationId,
                'user_id' => $user->id,
                'status' => 'invited',
            ]);

            $token = Str::random(64);

            OrganizationInvitation::query()->create([
                'organization_id' => $organizationId,
                'email' => $data->email,
                'token' => $token,
                'expires_at' => now()->addDays(7),
            ]);

            return [$member, $token];
        });

        $acceptanceUrl = rtrim(config('app.url'), '/').'/accept-invitation?token='.urlencode($token);

        Mail::raw(
            "You have been invited to join an organization. Accept your invitation and set a password: {$acceptanceUrl}",
            function ($message) use ($data): void {
                $message->to($data->email)->subject('Organization invitation');
            }
        );

        return $member;
    }
}
