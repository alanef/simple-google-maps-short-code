# Combined Verification Report: PLUGINS_SMALL-6 (SSFGM)

**Issue:** free_plugin_lib: setup notice can't be dismissed and never goes away (all free plugins)
**Date:** 2026-10-23
**Commit:** 0261795 (library v1.3.3)

## Executive Summary

| Review | Status |
|--------|--------|
| Commit Integrity | not-applicable (no claimed SHAs); change-set non-empty |
| Code Review | passed: library diff v1.3.0..v1.3.3 independently reviewed; critical finding fixed in 1.3.2 |
| Acceptance Review | passed for SSFGM |
| Browser-Test Gate | n-a: no layout change; notice HTML and redirects checked over HTTP |
| **Overall** | **APPROVED** |

## Where the code is
The fix is in alanef/free_plugin_lib; SSFGM's change is the constraint `^1.3.3` and changelog. Library evidence (35 PHPUnit
tests, per-fix mutation results, HTTP repro of the 1.3.1 redirect bug, independent review) is recorded in
alanef/stop-user-enumeration `.sdlc/PLUGINS_SMALL-6/verification.md` and the library CHANGELOG.

## SSFGM checks (wp-env, WP 7.1.3, admin, SSFGM-Free_form_rendered = rendering)
| Check | Result |
|---|---|
| Dashboard, admin-ajax heartbeat | 200, 200 (no redirect) |
| Notice | `data-shortname="SSFGM-Free"`, links to `options-general.php?page=ffpl-opt-in-SSFGM-Free` |
| Dismiss AJAX | `{"success":true}`; `SSFGM-Free_notice_dismissed` = 1; notice gone on reload |
| Settings page (SSFGM passes hook suffix `settings_page_simple-google-maps-settings`) | 302 to the opt-in screen (never redirected before 1.3.2) |
| Skip | 302; status `optout`; settings page then 200 |

Bundled library in the built zip: 1.3.3.

## Commit Range Covered
`0261795` only (Take free_plugin_lib 1.3.3 (PLUGINS_SMALL-6, PLUGINS_SMALL-7)). No out-of-range commits.

---
Verified by: AI Assistant
Date: 2026-10-23
