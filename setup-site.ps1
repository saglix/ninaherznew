param(
    [string] $Url = "http://localhost:8080",
    [string] $AdminEmail = "admin@example.local"
)

Set-StrictMode -Version Latest
$ErrorActionPreference = "Stop"

Push-Location "$PSScriptRoot\wordpress"

wp core language install he_IL --activate

if (-not (wp core is-installed 2>$null)) {
    wp core install `
        --url="$Url" `
        --title="Site" `
        --admin_user="admin" `
        --admin_password="1234" `
        --admin_email="$AdminEmail" `
        --locale="he_IL" `
        --skip-email
}

wp option update blogname "Site"
wp option update WPLANG "he_IL"
wp option update timezone_string "Asia/Jerusalem"
wp option update start_of_week 0
wp option update default_comment_status closed
wp option update default_ping_status closed
wp option update default_pingback_flag 0
wp option update comment_registration 1
wp option update close_comments_for_old_posts 1

$contentIds = wp post list --post_type=post,page --format=ids
if ($contentIds) {
    wp post delete $contentIds.Split(" ", [System.StringSplitOptions]::RemoveEmptyEntries) --force
}

wp plugin install wordpress-seo --activate
wp plugin install classic-editor --activate

wp theme activate saglixvibes
wp rewrite structure "/%postname%/"
wp rewrite flush

Pop-Location

Write-Host "WordPress site configured at $Url"
