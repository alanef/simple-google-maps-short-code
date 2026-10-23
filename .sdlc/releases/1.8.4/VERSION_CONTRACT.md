# Version Contract: 1.8.4

**Date:** 2026-10-23

## Canonical Source
Plugin header `Version:` in simple-google-maps-short-code/simple-google-map-short-code.php and `Stable tag:` in
simple-google-maps-short-code/readme.txt, written and read back by `scripts/release/bump-version.sh` (also package.json,
package-lock.json, changelog heading and .pot).

## Expected State After Deploy
- master holds 1.8.4 in all version locations and `= 1.8.4 =` at the top of changelog.txt
- Tag `v1.8.4` on master's HEAD; release.yml builds the zip and deploys to wp.org SVN (`Type: free`)
- wordpress.org/plugins/simple-google-maps-short-code reports 1.8.4 after the wp.org release confirmation
- The zip bundles alanef/free_plugin_lib 1.3.3 and uninstall.php

## Required Deploy Command
```
/tk-deploy live
```
Do not push tags outside `/tk-deploy live`.

## Post-Deploy Verification
See `.claude/commands/deploy-live.md`: GitHub release asset, SVN tag, KB changelog, YouTrack, then the wp.org release confirmation.
