# Casa Paraiso - Design System

This document outlines the visual language and design system for Casa Paraiso. It is meant to guide future development and ensure consistency across the application.

## Brand Identity

Casa Paraiso is a modern body and wellness spa. The design evokes a feeling of being:
- **Elegant & Premium:** High-quality experience without being ostentatious.
- **Warm & Natural:** Grounded and comforting.
- **Relaxing:** Uncluttered and easy on the eyes.

## Typography

We use two primary fonts to establish our brand voice:
- **Serif (Playfair Display):** Used for headings and logos. Evokes elegance and tradition.
  - Class: `font-serif`
- **Sans-Serif (Lato):** Used for body text and UI elements. Clean, modern, and highly legible.
  - Class: `font-sans`

## Color Palette

The color palette is rooted in natural elements.

### Primary Colors
- **Charcoal (`#171514`)**: The primary text and strong accent color. Used for headings, primary buttons, and deep contrast elements.
  - Tailwind: `spa-charcoal`
- **Espresso (`#4a2f22`)**: A warm, dark brown used for secondary accents, hover states, and warm backgrounds.
  - Tailwind: `spa-espresso`

### Accent Colors
- **Warm Brown (`#7a4f35`)**: Used for active states, borders, and warm highlights.
  - Tailwind: `spa-brown`
- **Wood (`#b8875b`)**: A lighter brown resembling natural wood. Used for subtle highlights, borders, and secondary text.
  - Tailwind: `spa-wood`
- **Gold (`#d6a85f`)**: An elegant accent color used for primary CTAs, active links, and focus rings.
  - Tailwind: `spa-gold`
- **Leaf Green (`#3f6f4e`)**: A natural green used for success states, wellness indicators, and natural accents.
  - Tailwind: `spa-leaf`

### Neutral Colors
- **Cream (`#f7f1e8`)**: The primary background color. Warmer and softer than pure white.
  - Tailwind: `spa-cream`
- **Beige (`#e8dbce`)**: Used for subtle section backgrounds, dividers, and inactive states.
  - Tailwind: `spa-beige`
- **Gray (`#6b635e`)**: Used for secondary text and muted elements.
  - Tailwind: `spa-gray`
- **White (`#ffffff`)**: Used for cards, elevated containers, and stark contrast on dark backgrounds.
  - Tailwind: `spa-white`

## UI Components

### Buttons
- **Primary Button (`.btn-primary`)**: Charcoal/Brown background with White text. Hover state shifts to a deeper espresso.
- **Secondary Button (`.btn-secondary`)**: White background with Wood/Charcoal text and Wood border.

### Cards & Containers
- **Card (`.card`)**: White background with soft shadows, subtle Beige border, and rounded corners (`rounded-xl` or `rounded-2xl`).

### Forms
- **Input Fields (`.input-field`)**: White background, Beige border, Wood focus ring, and Charcoal text.

## Layouts
The application uses consistent layout structures for different user roles:
- **Public**: Immersive hero sections, generous whitespace, and prominent CTAs.
- **Manager / Customer / Therapist Dashboards**: Sidebar navigation with Charcoal background, Cream main content area, and White cards. Active navigation links are highlighted with Gold.
