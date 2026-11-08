# Tests Passed: 1.8.4

**Date:** 2026-11-08T11:31:05Z
**Commit:** 0cd0a29371151c0808a0c92056a9878ec98b6e23
**Tracked changes at run time:** 1

| Gate | Result |
|---|---|
| composer install | pass |
| composer validate --strict | pass |
| composer run check | pass |
| version consistency | pass |
| build (composer run build) | pass |
| Plugin Check | not run locally (no plugin-check script); CI runs it on the built zip |
| PHPUnit (npm test) | SKIPPED: wp-env not running (--no-wp-env); CI tests job is the gate |

PHPUnit summaries:


Full output: tests.log (not committed).
