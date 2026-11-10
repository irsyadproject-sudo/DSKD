# ERD — Digital Project Management System (DPMS)

Diagram ini dibuat dengan sintaks [Mermaid](https://mermaid.js.org/syntax/entityRelationshipDiagram.html).
Untuk render: buka di GitHub, VS Code (ekstensi Mermaid), atau [Mermaid Live Editor](https://mermaid.live).

```mermaid
erDiagram
    roles ||--o{ users : "memiliki"
    users ||--|| clients : "detail akun"
    users ||--o{ projects : "PM menangani"
    users ||--o{ project_members : "anggota"
    users ||--o{ tasks : "ditugaskan"
    users ||--o{ files : "mengunggah"
    users ||--o{ comments : "menulis"
    users ||--o{ revisions : "meminta"
    users ||--o{ notifications : "menerima"
    clients ||--o{ projects : "memiliki"
    projects ||--o{ project_members : "merekrut"
    projects ||--o{ tasks : "berisi"
    projects ||--o{ files : "memiliki"
    projects ||--o{ comments : "memiliki"
    tasks ||--o{ files : "memiliki"
    tasks ||--o{ comments : "memiliki"
    tasks ||--o{ revisions : "direvisi"

    roles {
        bigint id PK
        string name UK
        string display_name
        timestamp created_at
        timestamp updated_at
    }

    users {
        bigint id PK
        bigint role_id FK
        string name
        string email UK
        timestamp email_verified_at
        string password
        string remember_token
        string avatar
        timestamp created_at
        timestamp updated_at
    }

    clients {
        bigint id PK
        bigint user_id FK "unique, 1-ke-1"
        string company_name
        string phone
        text address
        timestamp created_at
        timestamp updated_at
    }

    projects {
        bigint id PK
        bigint client_id FK
        bigint pm_id FK
        string name
        text description
        date start_date
        date deadline
        decimal budget
        enum priority "low | medium | high | urgent"
        enum status "draft | berjalan | review | revisi | selesai | dibatalkan"
        timestamp created_at
        timestamp updated_at
    }

    project_members {
        bigint id PK
        bigint project_id FK
        bigint user_id FK
        enum role_in_project "programmer | ui_ux_designer | graphic_designer | content_creator | video_editor"
        timestamp created_at
        timestamp updated_at
    }

    tasks {
        bigint id PK
        bigint project_id FK
        bigint assigned_to FK "nullable"
        string title
        text description
        enum priority "low | medium | high | urgent"
        date deadline
        enum status "to_do | in_progress | done"
        tinyint progress_percentage
        timestamp created_at
        timestamp updated_at
    }

    files {
        bigint id PK
        bigint project_id FK
        bigint task_id FK "nullable"
        bigint user_id FK
        string file_path
        string file_name
        string file_type
        timestamp created_at
        timestamp updated_at
    }

    comments {
        bigint id PK
        bigint project_id FK "nullable"
        bigint task_id FK "nullable"
        bigint user_id FK
        text comment
        timestamp created_at
        timestamp updated_at
    }

    revisions {
        bigint id PK
        bigint task_id FK
        bigint user_id FK
        text revision_description
        enum status "menunggu | diproses | selesai"
        timestamp created_at
        timestamp updated_at
    }

    notifications {
        bigint id PK
        bigint user_id FK
        string title
        text message
        boolean is_read
        timestamp created_at
        timestamp updated_at
    }
```