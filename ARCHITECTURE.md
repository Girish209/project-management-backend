# Modular monolith structure

Each business domain lives in `app/Modules/<ModuleName>`. A module owns its HTTP endpoints, application use cases, persistence details, and migrations. Modules can call another module's public actions or contracts, but should not reach into its repositories or models directly.

```text
app/Modules/Projects/
├── Actions/                 # One use case per class: CreateProjectAction
├── Contracts/               # Interfaces exposed by the module
├── DTOs/                    # Typed request/use-case data
├── Database/Migrations/     # Migrations owned by this module
├── Http/
│   ├── Controllers/         # Thin request/response adapters
│   ├── Requests/            # Validation and authorization
│   └── Resources/           # API response formatting
├── Models/                  # Eloquent models owned by the module
├── Providers/               # Bindings, routes, migrations
├── Repositories/            # Eloquent/query implementations
└── routes/api.php           # Routes owned by the module
```

## Request flow

`Route → Controller → Request validation → DTO → Action → Repository → Model`

Controllers do not contain business rules. Actions coordinate one business operation. Repositories contain database queries only; bind every repository interface in the module provider.

## Creating a new module

Copy `Projects` into a new PascalCase directory (for example, `Tasks`), rename its namespace and classes, then register its provider in `app/Providers/AppServiceProvider.php`. Keep cross-module concerns in `app/Shared` and infrastructure/framework configuration outside modules.

## Included example

After running migrations, the `Projects` module exposes these unauthenticated starter endpoints:

- `GET /api/projects`
- `POST /api/projects`
- `GET /api/projects/{project}`
- `PUT` or `PATCH /api/projects/{project}`
- `DELETE /api/projects/{project}`

Add authentication middleware and policies at the module route/controller level once the authorization rules are defined.
