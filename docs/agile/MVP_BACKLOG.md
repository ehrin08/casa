# MVP Backlog

## SPRINT 1: Foundation and Dashboard Setup
**Goal:** Finalize the project foundation and build the first usable dashboard structure.

### Finalize MVP backlog and sprint rules
- **User Story:** As a team member, I want clear agile documentation so that we can track our 6-week MVP build properly.
- **Acceptance Criteria:** SPRINT_RULES, MVP_BACKLOG, SPRINT_LOG, and TRELLO_CARD_TEMPLATE files exist in the repository.
- **Checklist:** [x] Write rules, [x] Define backlog, [x] Commit to GitHub.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** Done
- **Suggested Proof Required:** Screenshot of the GitHub repository containing the docs.

### Improve manager dashboard layout
- **User Story:** As a manager, I want a clean dashboard layout so that I can easily see my daily spa metrics.
- **Acceptance Criteria:** The manager dashboard uses Tailwind CSS to display a responsive grid layout.
- **Checklist:** [ ] Design grid, [ ] Apply Tailwind classes, [ ] Ensure mobile responsiveness.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of the new layout on desktop and mobile.

### Improve therapist dashboard layout
- **User Story:** As a therapist, I want a clear dashboard layout so that I can easily view my daily schedule and performance.
- **Acceptance Criteria:** The therapist dashboard has a dedicated responsive layout for their specific cards.
- **Checklist:** [ ] Design layout, [ ] Ensure mobile responsiveness.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of the new layout.

### Improve customer dashboard layout
- **User Story:** As a customer, I want a welcoming dashboard so that I can quickly find the booking link and my upcoming appointments.
- **Acceptance Criteria:** The customer dashboard is visually appealing and emphasizes the "Book Now" action.
- **Checklist:** [ ] Design layout, [ ] Emphasize booking button.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of the customer dashboard.

### Create reusable dashboard card components
- **User Story:** As a developer, I want to use reusable Blade components for dashboard cards so that the code is clean and maintainable.
- **Acceptance Criteria:** A single Blade component is used across all dashboards to render the placeholder metric cards.
- **Checklist:** [ ] Create `dashboard-card.blade.php`, [ ] Refactor existing dashboards to use it.
- **Suggested Priority:** Should Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Code snippet of the component usage.

### Add dashboard navigation polish
- **User Story:** As a user, I want smooth and clear navigation so that I know exactly what role I am logged in as and how to access my profile.
- **Acceptance Criteria:** The navigation bar clearly shows the user's role and is fully styled.
- **Checklist:** [ ] Style active links, [ ] Ensure dropdowns work perfectly on mobile.
- **Suggested Priority:** Could Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of the polished navigation bar.

---

## SPRINT 2: Service and Therapist Management
**Goal:** Allow management to maintain services and therapist records.

### Create service management CRUD
- **User Story:** As a manager, I want to create, read, update, and delete spa services so that the system always has accurate offerings.
- **Acceptance Criteria:** Manager can list, add, edit, and delete services from a dedicated page.
- **Checklist:** [ ] Create Service model/migration, [ ] Build Livewire CRUD component, [ ] Add validation.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Demo video or screenshot of a service being added.

### Create therapist profile management CRUD
- **User Story:** As a manager, I want to manage therapist profiles so that their details are up-to-date in the system.
- **Acceptance Criteria:** Manager can add new therapists and edit their basic information.
- **Checklist:** [ ] Create Therapist profile table/model, [ ] Build CRUD interface.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of the therapist list view.

### Add service duration and price fields
- **User Story:** As a manager, I want to define the duration and price for each service so that bookings and commissions can be calculated correctly.
- **Acceptance Criteria:** The Service CRUD includes fields for `price` (decimal) and `duration_minutes` (integer).
- **Checklist:** [ ] Update migration, [ ] Update form fields.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Code snippet of the database schema and a screenshot of the form.

### Add therapist availability structure
- **User Story:** As a manager, I want to define when a therapist is working so that customers cannot book them on their days off.
- **Acceptance Criteria:** A basic structure (database table or JSON field) exists to record working hours for each therapist.
- **Checklist:** [ ] Define availability schema, [ ] Add UI to update schedule.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of a therapist's schedule settings.

### Add manager-only access protection for management pages
- **User Story:** As a manager, I want my management pages protected so that customers and therapists cannot alter system data.
- **Acceptance Criteria:** Attempting to access the Service or Therapist management pages as a non-manager results in a 403 error.
- **Checklist:** [ ] Apply RoleMiddleware to new routes, [ ] Write test or manually verify.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of a 403 error when accessed by a customer.

---

## SPRINT 3: Booking Module
**Goal:** Allow customers and staff to create and manage appointments.

### Create customer booking form
- **User Story:** As a customer, I want a form to select a service, date, and time so that I can book an appointment.
- **Acceptance Criteria:** A functional Livewire form allows the user to submit a booking request.
- **Checklist:** [ ] Create Booking model/migration, [ ] Build form component, [ ] Add validation.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of the booking form.

### Show available services
- **User Story:** As a customer, I want to see a list of active services so that I can choose what I want to book.
- **Acceptance Criteria:** The booking form populates a dropdown dynamically from the Services database table.
- **Checklist:** [ ] Fetch active services, [ ] Render dropdown.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of the populated dropdown.

### Show available therapists
- **User Story:** As a customer, I want to choose a therapist who is available at my selected time so that my appointment is guaranteed.
- **Acceptance Criteria:** After selecting a date/time, the form only shows therapists who are scheduled to work and are not already booked.
- **Checklist:** [ ] Implement availability logic, [ ] Update UI dynamically via Livewire.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Demo video of selecting a time and seeing filtered therapists.

### Prevent overlapping therapist appointments
- **User Story:** As a manager, I want to prevent overlapping bookings so that therapists are not double-booked.
- **Acceptance Criteria:** The system rejects a booking if the requested time slot conflicts with an existing appointment for that therapist.
- **Checklist:** [ ] Add overlap validation logic.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of a validation error preventing a double-booking.

### Add booking status flow
- **User Story:** As a manager, I want bookings to have statuses (Pending, Confirmed, Completed, Cancelled) so that I can track their progress.
- **Acceptance Criteria:** Bookings have a status column. Managers can update the status from the dashboard.
- **Checklist:** [ ] Add status enum to database, [ ] Add UI controls to change status.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of a booking changing from Pending to Confirmed.

### Add manager booking calendar/list
- **User Story:** As a manager, I want to see all appointments in one place so that I can oversee daily operations.
- **Acceptance Criteria:** A dedicated page lists all upcoming and past bookings, filterable by date.
- **Checklist:** [ ] Create view, [ ] Add date filters.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of the master booking list.

### Add therapist schedule view
- **User Story:** As a therapist, I want to see only my assigned bookings so that I know who my next client is.
- **Acceptance Criteria:** The therapist dashboard correctly pulls and displays only bookings assigned to the logged-in therapist.
- **Checklist:** [ ] Query bookings by `therapist_id`, [ ] Display on therapist dashboard.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of the therapist's view of their schedule.

---

## SPRINT 4: Transactions and Commissions
**Goal:** Record completed services and compute therapist commissions.

### Convert completed booking to transaction
- **User Story:** As a manager, I want to convert a completed appointment into a financial transaction so that revenue is recorded.
- **Acceptance Criteria:** When a booking is marked "Completed," a Transaction record is automatically generated.
- **Checklist:** [ ] Create Transaction model/migration, [ ] Link to Booking, [ ] Automate creation on status change.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Database screenshot showing a new transaction linked to a completed booking.

### Add over-the-counter cash payment workflow
- **User Story:** As a manager, I want to log cash payments so that walk-in customers can be accommodated.
- **Acceptance Criteria:** Transactions can be recorded manually without a prior online booking.
- **Checklist:** [ ] Build manual transaction form.
- **Suggested Priority:** Should Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of the manual POS form.

### Record sales transactions
- **User Story:** As a manager, I want the total sales to be tracked accurately so that I can measure business health.
- **Acceptance Criteria:** The manager dashboard "Total Sales" card accurately reflects the sum of all completed transactions for the day/month.
- **Checklist:** [ ] Update dashboard logic to compute total sales from the database.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of the updated dashboard card.

### Compute therapist commission
- **User Story:** As a manager, I want the system to automatically calculate therapist commissions so that payroll is easier.
- **Acceptance Criteria:** The system calculates a fixed percentage (e.g., 10%) or fixed amount of the service price as commission for the assigned therapist.
- **Checklist:** [ ] Add commission logic, [ ] Store computed commission on the transaction.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Code snippet of the calculation logic.

### Add therapist commission view
- **User Story:** As a therapist, I want to see my estimated commissions so that I can track my earnings.
- **Acceptance Criteria:** The therapist dashboard "Estimated Commission" card displays the sum of their commissions for the current pay period.
- **Checklist:** [ ] Query transactions by `therapist_id`, [ ] Sum commissions, [ ] Display on dashboard.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of the therapist dashboard showing earnings.

### Add manager transaction list
- **User Story:** As a manager, I want a ledger of all transactions so that I can review financial history.
- **Acceptance Criteria:** A paginated table view showing all transactions with dates, amounts, and associated therapists/customers.
- **Checklist:** [ ] Create transaction list page, [ ] Implement pagination.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of the transaction ledger.

### Generate basic PDF report
- **User Story:** As a manager, I want to export transaction data as a PDF so that I can print the daily sales report.
- **Acceptance Criteria:** A button exists to download the filtered transaction list as a PDF document.
- **Checklist:** [ ] Install PDF package (e.g., barryvdh/laravel-dompdf), [ ] Build export function.
- **Suggested Priority:** Could Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** PDF file sample.

---

## SPRINT 5: Promotions, Analytics, and Sentiment
**Goal:** Add business intelligence features for management.

### Add RFM calculation
- **User Story:** As a manager, I want the system to calculate Recency, Frequency, and Monetary (RFM) scores for customers so that I can identify my best clients.
- **Acceptance Criteria:** A background job or direct query computes RFM segments for each customer based on their transaction history.
- **Checklist:** [ ] Define RFM logic, [ ] Display customer segments on the manager dashboard or customer list.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of a customer profile showing their RFM score.

### Add rule-based promotion settings
- **User Story:** As a manager, I want to create promotions tied to specific RFM scores so that I can target specific customer segments.
- **Acceptance Criteria:** A CRUD interface exists to define promotions (e.g., "10% off for VIPs").
- **Checklist:** [ ] Create Promotion model, [ ] Build CRUD UI.
- **Suggested Priority:** Should Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of the promotion settings page.

### Trigger customer promotion based on rule
- **User Story:** As a customer, I want to see promotions that apply to me so that I am incentivized to book again.
- **Acceptance Criteria:** The customer dashboard "Available Promotions" card displays offers matched to their specific RFM segment.
- **Checklist:** [ ] Match user to promotion, [ ] Display on customer dashboard.
- **Suggested Priority:** Should Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of a promotion appearing for a specific user.

### Add basic service popularity chart
- **User Story:** As a manager, I want to see which services are booked most often so that I can focus marketing efforts.
- **Acceptance Criteria:** A visual chart (bar or pie) on the manager dashboard shows the breakdown of bookings by service type.
- **Checklist:** [ ] Integrate a charting library (e.g., Chart.js), [ ] Feed booking data to the chart.
- **Suggested Priority:** Should Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of the chart.

### Add revenue summary chart
- **User Story:** As a manager, I want to see a trend line of my revenue so that I can track growth over time.
- **Acceptance Criteria:** A line chart displays daily or weekly revenue trends.
- **Checklist:** [ ] Query grouped transaction data, [ ] Render chart.
- **Suggested Priority:** Should Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of the revenue chart.

### Add peak booking hours chart
- **User Story:** As a manager, I want to know when my spa is busiest so that I can optimize staffing.
- **Acceptance Criteria:** A chart displays booking volume categorized by time of day.
- **Checklist:** [ ] Group bookings by hour, [ ] Render chart.
- **Suggested Priority:** Could Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of the peak hours chart.

### Add customer review form
- **User Story:** As a customer, I want to leave a review after my appointment so that I can share my feedback.
- **Acceptance Criteria:** A simple text area form is available for customers to submit feedback on completed appointments.
- **Checklist:** [ ] Create Review model, [ ] Build form UI.
- **Suggested Priority:** Should Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of the submitted review form.

### Add simple sentiment classification
- **User Story:** As a manager, I want reviews to be automatically tagged as Positive, Neutral, or Negative so that I can quickly assess customer satisfaction.
- **Acceptance Criteria:** The system runs a basic keyword-based or API-based sentiment analysis on submitted reviews and tags them appropriately.
- **Checklist:** [ ] Implement sentiment logic, [ ] Display badge next to reviews.
- **Suggested Priority:** Could Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of a review with a "Positive" or "Negative" tag.

---

## SPRINT 6: Testing, UAT, Deployment, and Documentation
**Goal:** Stabilize, deploy, and prepare for capstone demo.

### Run technical testing
- **User Story:** As a developer, I want to run all automated and manual tests so that I can catch regressions before deployment.
- **Acceptance Criteria:** A test report is generated showing that core features function correctly.
- **Checklist:** [ ] Run PHPUnit tests, [ ] Manually click through all pages.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of passing test results.

### Run role-based access testing
- **User Story:** As a QA tester, I want to aggressively test role restrictions so that no unauthorized access occurs in production.
- **Acceptance Criteria:** Verified that customers absolutely cannot access manager or therapist routes.
- **Checklist:** [ ] Attempt forced URL navigation with different accounts.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Test matrix document.

### Run booking conflict testing
- **User Story:** As a QA tester, I want to try to double-book a therapist so that I can verify the overlap prevention works perfectly.
- **Acceptance Criteria:** System successfully blocks intentional double-booking attempts.
- **Checklist:** [ ] Perform concurrent booking tests.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Notes confirming successful blockage.

### Run transaction and commission testing
- **User Story:** As a QA tester, I want to manually calculate commission payouts and compare them to the system so that I ensure financial accuracy.
- **Acceptance Criteria:** System totals exactly match manual calculator totals.
- **Checklist:** [ ] Generate test transactions, [ ] Verify math.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Spreadsheet showing math verification.

### Run User Acceptance Testing
- **User Story:** As a project stakeholder, I want real users to test the system so that we can gather usability feedback before the final presentation.
- **Acceptance Criteria:** At least 3 individuals have acted as "Customers" and successfully booked an appointment without developer assistance.
- **Checklist:** [ ] Conduct UAT session, [ ] Record feedback.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** UAT sign-off sheet.

### Fix critical and major bugs
- **User Story:** As a developer, I want to resolve all critical and major bugs found during UAT so that the demo goes smoothly.
- **Acceptance Criteria:** The issue tracker has 0 Critical and 0 Major bugs remaining.
- **Checklist:** [ ] Triage bugs, [ ] Fix bugs, [ ] Re-test.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Screenshot of empty bug tracker.

### Deploy to hosting
- **User Story:** As a team, we want the system accessible via a public URL so that we can demonstrate it during our capstone defense.
- **Acceptance Criteria:** The application is live on a production server (e.g., Hostinger, DigitalOcean, or Laravel Forge) with a working database.
- **Checklist:** [ ] Provision server, [ ] Upload code, [ ] Configure production `.env`, [ ] Run production migrations.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Link to the live public URL.

### Prepare user manual
- **User Story:** As a project team, we want a written user manual so that the spa staff can learn how to use the system.
- **Acceptance Criteria:** A PDF or Markdown document explains the basic workflows (booking, checking out, managing services) with screenshots.
- **Checklist:** [ ] Draft document, [ ] Add screenshots, [ ] Finalize formatting.
- **Suggested Priority:** Should Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Link to the user manual file.

### Prepare final demo script
- **User Story:** As a presenter, I want a script to follow during the capstone defense so that the presentation is smooth and covers all MVP requirements.
- **Acceptance Criteria:** A step-by-step guide on what to click and say during the live demo.
- **Checklist:** [ ] Write script, [ ] Practice run-through.
- **Suggested Priority:** Must Have
- **Suggested Trello Status:** To Do
- **Suggested Proof Required:** Link to the script document.
