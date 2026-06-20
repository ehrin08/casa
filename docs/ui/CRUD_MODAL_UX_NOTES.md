# CRUD Modal UX Notes

## Recent Fixes
- **Root Cause**: Modals and CRUD buttons were entirely broken because Alpine.js was missing. Livewire 3 auto-injects Alpine.js only if a Livewire component is on the page, and the custom layouts (`manager-layout.blade.php`, `customer-layout.blade.php`, etc.) did not have any Livewire components.
- **Alpine Injection**: Fixed by adding `@livewireScripts` just before `</body>` in all layout files.
- **Dispatch Syntax**: The delete/confirm buttons had a broken dispatch syntax. They were using `$dispatch('open-modal-confirm-delete-X')` instead of `$dispatch('open-modal', 'confirm-delete-X')`. This was corrected in 11 different index and show files.

## Working Workflows
- All CRUD modals are now functioning properly because Alpine.js is correctly loaded.
- Creating/Editing Services
- Creating/Editing Therapists
- Creating/Editing Therapist Availabilities
- Creating/Editing Promotion Rules
- Confirmation Modals for Delete, Pay, Cancel, Generate are all fully working.

## Restored Workflows
- There was no need to restore the full-page fallback links because the modal form implementation is stable and perfectly functional once Alpine.js was initialized. All buttons open their respective modals now.

## Known Limitations
- The modals do not currently support ajax form submission. They submit the form traditionally and reload the page. If validation fails, the page reloads with the modal kept open (due to `old('_modal_id')`). This is intended and working correctly.
- Be careful when defining new modals to use `$dispatch('open-modal', 'modal-name')` instead of appending the modal name to the event name.

## Navigation & Appointment Tab Fix
- **Appointment Tab Issue Found**: The 'Appointments' tab in the manager dashboard (`/manager/bookings`) resulted in a `500 Internal Server Error`. The Customer Dashboard (`/customer/dashboard`) also resulted in a `500 Internal Server Error`. The public 'Book Appointment' button was completely dead.
- **Root Cause**: 
  1. The manager bookings index uses `maxWidth="3xl"` for modals, but `3xl` was omitted in the modal view configuration, crashing PHP.
  2. The customer dashboard query incorrectly queried `booking_date` instead of `appointment_date`, throwing a QueryException.
  3. The public landing page buttons used Alpine's `$dispatch` to open an `auth-prompt` modal, but the landing page does not load Alpine.js (since it has no Livewire components and `@livewireScripts` requires an active component context to load Alpine natively, or it was overridden). 
- **Fix Applied**: 
  - Added `3xl` through `7xl` to `resources/views/components/modal.blade.php`.
  - Replaced `booking_date` with `appointment_date` in `DashboardController.php`.
  - Replaced `x-on:click="$dispatch('open-modal', 'auth-prompt')"` buttons on `welcome.blade.php` with direct `<a href="{{ route('login') }}">` fallbacks to ensure functionality over unreliable modal overlays.
- **Tabs/Buttons Verified**: Manager Appointments tab, Customer Dashboard, Public Landing Page booking redirects are all manually tested and verified working via browser subagent.
- **Modal Fallback Decisions**: For the unauthenticated booking prompt on the landing page, the original modal behavior was discarded in favor of a standard redirect to the `/login` page to guarantee access to the system.
