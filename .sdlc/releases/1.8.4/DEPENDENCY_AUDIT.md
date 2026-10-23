# Dependency Audit: 1.8.4

**Date:** 2026-10-23T10:32:13Z
**Commit:** e56e3ee

| Tree | Policy | Exit | Result |
|---|---|---|---|
| plugin composer (no dev) | block | 0 | clean |
| root composer (tooling) | warn | 0 | clean |
| npm (dev env / build) | warn | 1 | advisories |

## plugin composer (no dev)
```
No security vulnerability advisories found.
```
## root composer
```
No security vulnerability advisories found.
```
## npm
```
### repository root (exit 1)
js-yaml  <=3.15.1
Severity: high
js-yaml has prototype pollution in merge (<<) - https://github.com/advisories/GHSA-mh29-5h37-fv8m
JS-YAML: Quadratic-complexity DoS in merge key handling via repeated aliases - https://github.com/advisories/GHSA-h67p-54hq-rp68
js-yaml: YAML merge-key chains can force quadratic CPU consumption - https://github.com/advisories/GHSA-52cp-r559-cp3m
JS-YAML: Quadratic CPU consumption in !!omap resolution (3.x and 4.x) — CVE-2026-59870 fix not backported - https://github.com/advisories/GHSA-5p4m-2wfm-xmqj
js-yaml: maxTotalMergeKeys does not limit CPU use for empty merge sources - https://github.com/advisories/GHSA-2883-xcg3-v3hh
fix available via `npm audit fix`
node_modules/js-yaml

proxy-addr  1.1.0 - 2.0.7
Severity: critical
proxy-addr vulnerable to IP spoofing via IPv4-mapped IPv6 trust subnet - https://github.com/advisories/GHSA-jqcg-44mw-7w3h
fix available via `npm audit fix`
node_modules/proxy-addr

qs  2.2.5 - 6.15.3
Severity: moderate
qs array-limit bypass via bracket-key comma parsing - https://github.com/advisories/GHSA-x5fp-wj9c-mxmx
qs: Denial of Service via Attacker Controlled isBuffer - https://github.com/advisories/GHSA-4mjr-xmp4-gh2g
fix available via `npm audit fix`
node_modules/qs
  body-parser  1.20.5 - 1.20.6
  Depends on vulnerable versions of qs
  node_modules/body-parser
  express  4.22.2
  Depends on vulnerable versions of qs
  node_modules/express
    @wp-playground/cli  >=3.1.38
    Depends on vulnerable versions of express
    node_modules/@wp-playground/cli


13 vulnerabilities (5 moderate, 5 high, 3 critical)

To address issues that do not require attention, run:
  npm audit fix

To address all issues (including breaking changes), run:
  npm audit fix --force

```
