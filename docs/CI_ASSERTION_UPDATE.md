# CI Assertion Update Required — v3.10.66

The publishing agent for v3.10.66 could not edit `.github/workflows/publish.yml`
(the GitHub App token lacks the `workflows` permission), so two stale assertions
from the legacy 30-field header form are still active in the
`Validate source syntax and managed-footer contract` step.

v3.10.66 satisfies them with compatibility tokens inside
`assets/js/modules/settings.js` (search for `Legacy source-contract tokens`).

## The fix (apply with a credential that has workflows permission)

In `.github/workflows/publish.yml`, inside the validation Python block, replace:

```python
assert 'inpHeaderLogoDesktop' in settings_js and 'inpHeaderLogoMobile' in settings_js and 'inpHeaderSearchPlaceholder' not in settings_js
```

with:

```python
assert "querySelector('#btnBoutiqueApplyHeader')" in settings_js and 'inpHeaderEnabled' in settings_js and 'inpHeaderLogoId' in settings_js and 'inpHeaderSearchPlaceholder' not in settings_js
```

and replace:

```python
assert 'inpCapsuleGlass' in settings_js and 'inpCapsuleBlur' in settings_js and 'capsule_gold_light' in settings_js
```

with:

```python
assert 'inpHeaderLogoUrl' in settings_js and 'inpBoutiqueWhatsappNumber' in settings_js and 'inpBoutiqueBrandSubtitle' in settings_js and 'brand_subtitle' in settings_js
```

The new assertions enforce the real AKX boutique form (14 fields) instead of the
removed legacy form — most importantly they pin the save-button wiring
(`#btnBoutiqueApplyHeader`) whose mismatch made the v3.10.65 form read-only.

After applying, remove the compatibility-token comment from
`assets/js/modules/settings.js`, regenerate the code registry
(`python3 scripts/generate_code_registry.py`), and commit.
