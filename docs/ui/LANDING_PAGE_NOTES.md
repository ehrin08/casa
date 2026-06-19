# Public Landing Page Notes

## Purpose
The public landing page acts as the primary entry point for guests visiting the Casa Paraiso – Body and Wellness Spa web system. It provides an immediate sense of the spa's identity, features the available services, explains the booking process, showcases current promotions, and highlights customer sentiment through verified reviews. Importantly, it directs users efficiently into the booking flow (by enforcing login/registration) while preventing unauthorized access to the internal dashboards.

## Sections Included
1. **Header & Navigation**: Sticky header with logo, anchor links for smooth scrolling to sections, and context-aware Authentication/Dashboard links. Mobile responsive menu included.
2. **Hero Section**: High-impact introduction with clear "Book Appointment" and "View Services" calls-to-action.
3. **Featured Services Preview**: Dynamically fetches up to 6 active services to display their pricing, duration, and descriptions.
4. **How It Works**: A concise, 4-step guide detailing the simple booking and payment process.
5. **Why Choose Us**: Value proposition highlighting features like real-time availability and personalized promotions.
6. **Promotions Preview**: Displays up to 3 active, generic promotion rules. Prompts guests to log in to see their specific available promos.
7. **Reviews Preview**: Showcases up to 3 recent, visible customer reviews. Replaces full names with a secure generic format (e.g., "John M.") to preserve customer privacy.
8. **Contact & Footer**: Contains placeholders for location, contact info, operating hours, social media links, and capstone disclaimers.

## HCI Principles Applied
- **Visibility and Feedback**: Hover states and transition effects on buttons and links provide immediate visual feedback.
- **Consistency**: Buttons, typography, colors, and layout structure use the defined Spa theme consistently. `x-public-layout` ensures a unified structure.
- **Error Prevention & Constraint**: The main "Book Appointment" CTA dynamically routes users depending on authentication state (guests are routed to `/login`, managers/therapists are routed to their dashboard to prevent accidental customer bookings).
- **Aesthetics and Minimalist Design**: Used a clean beige and deep green color palette (`#fdfcfb` and `#2c3e38`) with plenty of white space. No distracting clutter.
- **Empty States**: If no services, reviews, or promotions exist, the page gracefully degrades to show a friendly "coming soon" message instead of breaking or showing blank tables.

## Data Exposure & Privacy
**Data Shown Publicly:**
- Active Services (Name, Category, Duration, Price, Description)
- Active Generic Promotion Rules (Name, Value, Expiry Date)
- Visible Reviews (Rating, Snippet/Comment, Service Name, First Name Initial of Customer)

**Data Intentionally Hidden:**
- Exact customer full names (obfuscated in reviews).
- Internal performance metrics, analytics, revenue, and transaction details.
- Specific customer promotions mapped to individual user IDs.
- Therapist full names in reviews (only the service name is shown on the review card).

## Remaining Content Placeholders
The following sections use placeholder text that should be updated before production:
- Contact number (`[Contact number placeholder]`)
- Operating hours (`[Operating hours placeholder]`)
- Facebook page link URL

## Testing Conducted
- `php artisan migrate:fresh --seed`
- Verified guest access, mobile responsiveness, and empty state behaviors.
- Verified authenticated users see "Dashboard" instead of Login/Register.
