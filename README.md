# Nina WordPress Website

This workspace contains the WordPress codebase for the Nina website.

## What Is Included In Git

- Custom theme in `wordpress/wp-content/themes/saglixvibes`
- Local setup scripts: `setup-site.ps1` and `start-site.ps1`
- Production config template: `production-wp-config-template.php`

## Local Workspace

This local workspace includes WordPress core, a portable PHP runtime and an SQLite database, but runtime/generated files are intentionally excluded from Git.

Start the local site with:

```powershell
.\start-site.ps1
```

Then open:

```text
http://localhost:8080/
```

Local admin login:

```text
http://localhost:8080/wp-admin/
username: admin
password: 1234
```

The site has:

- Site title: `Site`
- Admin user: `admin`
- Admin password: local development password only
- Language: Hebrew (`he_IL`)
- Timezone: `Asia/Jerusalem`
- Week starts on Sunday
- Comments and pingbacks disabled
- Posts and pages deleted
- Yoast SEO and Classic Editor activated
- Custom theme activated
