# Multi-tenant SaaS schema and module plan

## Core tenancy model

Use a shared database. An organization is the tenant and a user is a global identity.

```text
users ──< organization_members >── organizations
```

Use `organization_members`, rather than `employees`, because it supports employees, owners, contractors, and guests. A single user can belong to multiple organizations and hold a different role in each one.

## Tenant safety rules

1. Every organization-owned table includes `organization_id`.
2. Middleware resolves the current organization from a trusted route, subdomain, or organization switcher.
3. Middleware verifies that the authenticated user has an active membership before setting the current organization.
4. Every repository scopes tenant-owned queries to the current organization.
5. Policies and route bindings verify that a resource belongs to the current organization.

```text
Request → authenticate → resolve organization → verify membership
        → set CurrentOrganization → scoped repository → response
```

## Tables

### Identity and tenancy

#### users

Global login identity:

```text
id, name, email (unique), password, avatar_path (nullable),
email_verified_at (nullable), timestamps
```

#### organizations

The tenant:

```text
id, name, slug (unique), logo_path (nullable), owner_id → users.id,
timezone, settings (json, nullable), timestamps
```

#### organization_members

The member's profile inside a particular organization; this backs the frontend's employee screens:

```text
id
organization_id → organizations.id
user_id → users.id
first_name, last_name
employee_code, phone, department, designation (all nullable)
status: invited | active | disabled
joined_at (nullable)
timestamps

unique (organization_id, user_id)
index  (organization_id, status)
```

#### organization_invitations

```text
id, organization_id, email, role_id (nullable), token (unique),
invited_by_member_id, expires_at, accepted_at (nullable), timestamps

index (organization_id, email)
```

### Teams

Internal teams are organizational groups—not the same thing as Spatie's permission team context.

```text
teams:
  id, organization_id, name, description, department,
  lead_member_id, status: active | inactive, timestamps
  unique (organization_id, name)

team_members:
  team_id, organization_member_id, timestamps
  unique (team_id, organization_member_id)
```

### Projects

```text
projects:
  id, organization_id, key, name, description,
  status: planning | active | on_hold | completed | archived,
  owner_member_id, start_date, end_date, archived_at, timestamps
  unique (organization_id, key)
  index  (organization_id, status)

project_members:
  project_id, organization_member_id, joined_at, timestamps
  unique (project_id, organization_member_id)
```

A project member must first be an active organization member.

### Tasks and collaboration

```text
tasks:
  id, organization_id, project_id, parent_task_id (nullable),
  title, description, status, priority,
  created_by_member_id, reporter_member_id (nullable),
  due_date, estimated_minutes, sort_order, completed_at, timestamps
  index (organization_id, project_id, status)
  index (organization_id, due_date)

task_assignees:
  task_id, organization_member_id, is_primary, timestamps
  unique (task_id, organization_member_id)

labels:
  id, organization_id, name, color, timestamps
  unique (organization_id, name)

label_task:
  label_id, task_id

task_comments:
  id, organization_id, task_id, author_member_id, body, timestamps

task_watchers:
  task_id, organization_member_id
  unique (task_id, organization_member_id)

attachments:
  id, organization_id, attachable_type, attachable_id,
  disk, path, uploaded_by_member_id, timestamps
```

Use `task_assignees` even if the first frontend version displays one assignee. It preserves the option of multi-assignee tasks without a schema redesign.

### Cross-cutting

```text
activity_logs:
  id, organization_id, actor_member_id (nullable), event,
  subject_type, subject_id, properties (json), created_at
  index (organization_id, subject_type, subject_id)

subscriptions:
  id, organization_id, provider_customer_id, provider_subscription_id,
  plan, status: trial | active | past_due | cancelled | expired,
  trial_ends_at, current_period_ends_at, timestamps
  unique (organization_id)
```

Use Laravel database notifications; include `organization_id` in notification data so the frontend navigates in the right tenant context.

## Roles and permissions

Use `spatie/laravel-permission` with teams enabled, but make its team context the organization:

```text
Spatie permission team = organization / tenant
Application team       = internal department or delivery team
```

Configure this before running the package migrations:

```php
'teams' => true,
'team_foreign_key' => 'organization_id',
```

Set the active organization as Spatie's permission team in organization middleware. This permits roles such as:

```text
User A + Organization Alpha → Admin
User A + Organization Beta  → Member
```

Seed application-owned permissions:

```text
organization.manage
members.view, members.invite, members.manage
roles.manage
teams.view, teams.manage
projects.view, projects.create, projects.update, projects.archive
tasks.view, tasks.create, tasks.update, tasks.assign, tasks.delete
reports.view
billing.manage
```

Suggested initial roles:

```text
Owner            all permissions
Admin            operational administration
Project Manager  project and task management
Member           assigned-project access and own task updates
Viewer           read-only
```

The frontend role UI needs `description`, `color`, and `is_system`. Create a custom Spatie Role model and add those columns to the package's `roles` table. Derive friendly permission labels/modules from names like `projects.update`; add permission metadata only if administrators need to edit labels.

Use policies as well as permissions: a permission allows a capability broadly, while a policy confirms that the resource belongs to the active organization and checks project-level membership where required.

## Module boundaries

```text
Identity          users, authentication, password reset, Passport tokens
Organizations     tenants, memberships, invitations, organization settings
AccessControl     Spatie roles, permission seeding, authorization policies
Teams             internal teams and team membership
Projects          projects and project membership
Tasks             tasks, assignees, labels, comments, task workflow
Notifications     in-app/email notifications and preferences
Activity          audit trail and activity feed
Reports           tenant-scoped reporting/read models
Billing           plans, subscriptions, usage limits
Files             attachments and secure file access
```

Each module owns its models, actions, repositories, DTOs, HTTP layer, routes, and migrations. Modules communicate through public actions or contracts, not another module's repositories.

## Recommended delivery order

1. Identity, Organizations, and organization membership.
2. Tenant resolution middleware, scoped repositories, and policies.
3. Spatie permissions, organization-scoped roles, and permission seeder.
4. Invitations and internal teams.
5. Projects and project membership.
6. Tasks, labels, assignees, comments, and activity events.
7. Notifications and reports.
8. Billing, usage limits, and file attachments.

## Immediate change to the starter Projects module

Replace the initial standalone project table with tenant-aware fields: `organization_id`, `key`, `owner_member_id`, dates, archive state, and a `project_members` table. Every project repository query must filter by the current organization.

