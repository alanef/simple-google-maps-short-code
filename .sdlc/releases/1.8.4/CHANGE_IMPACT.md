# Change Impact Assessment: 1.8.4

## Risk Level: Medium

The opt-in fixes are low risk. The map script moving to the footer is the one front-end change on every site using the
shortcode, so this release is Medium.

### Factors Considered
- Number of issues: 3 + 1 untracked change
- Security-sensitive changes: 0 (one hardening: skip needs manage_options)
- API changes: no; shortcode attributes and the sgmsc_atts / sgmsc_map_options filters are unchanged
- Database changes: no; uninstall now removes one option
- Breaking changes: none intended (see below)

## Affected Areas
- `simple-google-map-short-code.php`: the shortcode now enqueues the Maps API (handle `pw-map-google-maps-<key hash>`) and adds
  each map's init with wp_add_inline_script. Container markup is unchanged.
- `uninstall.php` (new): removes `SSFGM-Free_form_rendered`.
- Bundled `alanef/free_plugin_lib` 1.2.4 -> 1.3.3: the opt-in notice, dismissal, redirect, and plugin_map lookup.

## Who could notice
- Themes with no `wp_footer()` call: footer scripts never print, so maps would not start. Before, they worked without the
  footer. This is rare: themes are required to call wp_footer.
- Caching or optimisation plugins that defer or combine footer scripts: the API and init are one handle plus its "after"
  inline, so they stay together. If a plugin defers the API and runs the inline immediately, `google` is undefined.
- Content inserted later by JavaScript that doesn't run scripts: no change from before.

## Rollback Plan

### Immediate Rollback
`git revert e56e3ee` restores inline script tags, but Plugin Check then fails again. Otherwise re-release 1.8.3's tree as
1.8.5. On wp.org a rollback ships as a new version.

### Database Rollback
N/A

## Monitoring
- wp.org support forum for "map not showing" reports after 1.8.4
- Plugin reviews during the release period
