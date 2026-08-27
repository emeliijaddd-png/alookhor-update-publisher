# MASTER DESIGN DIRECTIVE — ALOOKHOR

**Status:** Canonical / Non-negotiable  
**Effective:** 2026-08-27  
**Scope:** Homepage, all managed shortcodes, Elementor/WoodMart surfaces, responsive states, and future UI.

## Brand DNA
Premium Iranian Food & Export Brand: Luxury, Natural, Authentic Iranian, Premium Food, Export/B2B. The storefront must never resemble SaaS, technology retail, a dashboard, an inexpensive food template, or an all-page dark theme.

## Canonical palette (no additions)
```css
:root {
  --alookhor-purple: #3B164F;
  --alookhor-deep-purple: #16091F;
  --alookhor-gold: #D4AF37;
  --alookhor-light-gold: #F5D76E;
  --alookhor-cream: #FAF5EA;
  --alookhor-white: #FFFFFF;
  --alookhor-dark-card: #21132B;
  --alookhor-text-light-muted: #E5E5E5;
}
```

- Pure black `#000000` is prohibited everywhere.
- Off-palette blue, green, red, orange, cold grey, neon, random purple and multicolour gradients are prohibited, except minimal semantic system feedback where functionally necessary.
- Gold is an accent—not paragraph text, large backgrounds, all headings, all navigation, or all CTAs.

## Contrast
- White/Cream surfaces: primary text `#3B164F`.
- Purple/Deep Purple surfaces: primary text `#FFFFFF`.
- Normal text target ≥ 4.5:1; large text ≥ 3:1.

## Homepage rhythm
Header Deep Purple Glass → Hero Photography/Purple Overlay → Trust White → About Cream → Why White → Statistics Purple → Categories Cream → Featured Products White → Promo Purple → Export Deep Purple → Sorting Cream → Story White → Process Cream → Standards Deep Purple → Destinations White → Magazine Cream → Newsletter Purple → Footer Deep Purple.

Adjacent sections must not repeat the same background/card/border/shadow/layout without a justified compositional reason.

## Component mapping
- Header: `rgba(22,9,31,.72)`, blur 18px, subtle gold border, white text.
- Hero: real premium photography, purple overlay `.30–.40`, white heading, gold highlight.
- Trust: white section, cream cards, purple text, gold line icons.
- Categories: cream section, white photography-led cards.
- Featured products: white section, cream/white minimal cards; hierarchy Image → Name → Attribute → Price → CTA.
- Promo: Primary Purple.
- Export/B2B and standards: Deep Purple with `#21132B` cards.
- Sorting/packaging and process: Cream with white text surfaces.
- Magazine: Cream with white photography-led cards.
- Newsletter: Primary Purple, white input, gold button.
- Footer: Deep Purple, gold column headings, `#E5E5E5` links/text.

## Typography
Vazirmatn is the primary Persian font, self-hosted WOFF2. Persian body copy uses line-height 1.8–2.0. Avoid small compressed text and indiscriminate bold weights.

## Radius
Small 12px; Medium 20px; Large 28px; Hero/large imagery 32px.

## Motion
Only slow, subtle, purposeful Fade, Reveal, minimal Image Zoom, Hover Lift and Opacity transitions. No bounce, flash, oversized parallax or excessive motion. Respect `prefers-reduced-motion`.

## Mobile
Mobile is independently composed, touch-safe and content-led—not merely scaled desktop. Floating elements must never cover primary content or CTAs.

## Accessibility and content
Semantic HTML, real indexable text, descriptive alt text, valid heading hierarchy, visible focus, adequate contrast. Color cannot be the sole carrier of meaning.

## Imagery
Real, premium, warm, authentic, high-resolution editorial photography. Priority: real product/orchard/harvest/processing/export photography over stock, and stock over illustration. Avoid visibly synthetic AI imagery.

## Implementation rule
All managed components must consume the canonical global tokens. New hard-coded visual colors are prohibited. If emphasis is needed, use spacing, typography, photography, weight, border, shadow and composition before color.

## Final QA gate
Before a visual release, verify: no pure black; no off-palette identity color; balanced light/dark rhythm; no excessive gold; photography prominence; correct hierarchy; readable contrast; real mobile responsiveness; restrained cards; credible B2B/export character; authentic Iranian/natural character; no decorative element without purpose.

## Warm Luxury Surface Amendment — 2026-08-27
The owner approved replacing stark white section backgrounds with a warmer plum-compatible luxury surface set:

```css
--alookhor-warm-light: #F3EBDD;
--alookhor-warm-secondary: #EDE2D0;
--alookhor-warm-card: #FFF9EF;
```

`#FFFFFF` remains valid for high-contrast text and limited functional use, but is no longer the default large section background. Light rhythm now alternates Warm Light → Sand → Warm Light while cards use Premium Ivory. Purple, Deep Purple and Gold remain unchanged.

## Rich Plum Surface Amendment — 2026-08-27
At the owner's explicit direction, the warm light large surfaces from v3.10.121 are superseded by a new Rich Plum token `#2B0D3A`. Managed Trust, Categories, Product, Sorting, App and Magazine sections use Rich Plum as their large surface, Primary Purple `#3B164F` as card depth, Deep Purple `#16091F` for inset surfaces, white text and restrained gold accents. The warm tokens remain archived but are not active storefront surfaces.

## Alternating Plum Rhythm Amendment — 2026-08-27
At the owner's direction, managed Homepage content sections alternate by actual DOM order between `#2B0A3D` and `#3A0D5C`. Header, Hero and Footer retain their dedicated role colors. The runtime assigns deterministic A/B surface classes after Elementor renders, and each section plus its host receives the same token to prevent seams.

## Three-step Container Rhythm Amendment — 2026-08-27
The previous two-color alternation is superseded by a deterministic three-step DOM rhythm: `#1C1025` → `#26213D` → `#1D1126` → repeat. Each managed section and its Elementor host share the same assigned surface. Header, Hero and Footer remain role-specific.

## Strict Three-purple Palette Amendment — 2026-08-27
The active storefront surface system is now strictly limited to `#1C1025`, `#26213D`, and `#1D1126`. Legacy Primary/Deep/Card surface tokens are remapped to this trio. Every managed module has a static fallback assignment, while runtime DOM alternation uses the same three values. Gold, light gold, white and muted light remain text/accent colors only.
