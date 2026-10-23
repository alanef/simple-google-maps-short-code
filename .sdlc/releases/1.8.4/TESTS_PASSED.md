# Tests Passed: 1.8.4

**Date:** 2026-10-23T10:33:08Z
**Commit:** d38fd39020d3dc7515fa65bd84e0670b5a0fa2b9
**Tracked changes at run time:** 1

| Gate | Result |
|---|---|
| composer install | pass |
| composer validate --strict | pass |
| composer run check | pass |
| version consistency | pass |
| build (composer run build) | pass |
| Plugin Check | not run locally (no plugin-check script); CI runs it on the built zip |
| PHPUnit (npm test) | pass |

PHPUnit summaries:

    OK (3 tests, 6 assertions)

Full output: tests.log (not committed).
