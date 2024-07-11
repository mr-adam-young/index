# index.ps1
# prototype for command line interface

# I have to digitally sign this to run it. 

# Usage: ./index-cli.ps1 -make "readme"
param($make)
Write-Host "passed arg: $make"

switch ($make) {
    "readme" {
        Write-Host "making readme"
        # make readme
    }
    "index" {
        Write-Host "making index"
        # make index
    }
    default {
        Write-Host "no arg passed"
    }
}


# PowerShell command for archiving a directory to .history
# (exclude hidden folders in search)

# Generate readme.md - add to PATH

# index archive this
# */