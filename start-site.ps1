Set-StrictMode -Version Latest
$ErrorActionPreference = "Stop"

$php = Join-Path $PSScriptRoot "runtime\php\php.exe"
$router = Join-Path $PSScriptRoot "wordpress\router.php"

if (-not (Test-Path $php)) {
    throw "Portable PHP was not found at $php"
}

Push-Location "$PSScriptRoot\wordpress"
& $php -S 127.0.0.1:8080 -t . $router
Pop-Location
