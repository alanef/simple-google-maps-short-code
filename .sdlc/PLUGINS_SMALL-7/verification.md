# Combined Verification Report: PLUGINS_SMALL-7 (SSFGM)

**Issue:** free_plugin_lib: "Allow & Continue" subscribes nobody in SSFGM, MMT, LHF and RSHFD (plugin_map gap)
**Date:** 2026-10-23
**Commit:** 0261795 (library v1.3.3, fix 0885daf)

## Executive Summary

| Review | Status |
|--------|--------|
| Commit Integrity | passed: 0885daf and 4f34052 (Release 1.3.3) on free_plugin_lib main, tag v1.3.3 |
| Code Review | passed: a `-Free` shortname falls back to the map entry without the suffix; skip now needs manage_options |
| Acceptance Review | passed for SSFGM |
| Browser-Test Gate | not-applicable |
| **Overall** | **APPROVED** |

## Evidence
- Library: the 4 `-Free` tests and the skip-capability test fail on 1.3.2 and pass on 1.3.3; the controls (exact key CSCF,
  unknown names with and without -Free) are unchanged. 35 tests, CI green on 0885daf.
- SSFGM in wp-env: `Email('SSFGM-Free')->handle_optin_submission()` returned true and the captured request body carried
  `plugin_id: ssfgm` (pre_http_request returned a fake 200; nothing reached the real webhook).
- Decision (Alan): no re-prompting; users stored as optout stay as they are. No reset logic added.

## Uninstall (part of this rollout, decided by Alan)
`uninstall.php` (new) calls only `Main::plugin_uninstall( 'SSFGM-Free' )`, which deletes only the
`SSFGM-Free_form_rendered` site option. SSFGM stores no options of its own (only geocode transients keyed by address
hash, which expire after 3 months). `wp plugin uninstall --skip-delete` removed the option.

## Commit Range Covered
`0261795`. No out-of-range commits.

---
Verified by: AI Assistant
Date: 2026-10-23
