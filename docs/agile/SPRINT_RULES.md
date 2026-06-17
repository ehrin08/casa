# Agile Sprint Rules

## 6-Week Agile Sprint Structure
The project is built on a 6-week MVP timeline, organized into weekly sprints.

## Weekly Sprint Flow
1. **Sprint Planning**: Define and select the cards for the current week.
2. **Daily Check-in**: Briefly state what was done, what will be done, and any blockers.
3. **Development**: Work on the user stories defined in the Trello/MVP backlog.
4. **Testing**: Run local tests to ensure the feature meets acceptance criteria.
5. **Sprint Review**: Evaluate the completed features at the end of the sprint.
6. **Sprint Retrospective**: Identify what went well and what can be improved for the next sprint.

## Sprint Rules
- Keep the MVP scope **fixed** after Week 2 unless a change is explicitly required by the project adviser.
- Any unfinished tasks from the current sprint should be moved to the next sprint if needed.
- No feature is considered "Done" unless it is fully tested and successfully committed to the main GitHub repository.
- Every completed major feature must have **screenshot or demo proof** attached to its documentation or Trello card.
- **Do NOT** add out-of-scope features (e.g., native mobile app, SMS notifications, online payment gateways, inventory management, or full payroll) until the core MVP is 100% complete.

## Definition of Ready
A task is "Ready" to be worked on when:
- The user story is clearly written.
- The acceptance criteria are defined.
- UI/UX expectations (if any) are understood.

## Definition of Done
A task is "Done" when:
- The code works correctly on the local environment without errors.
- Tests (manual or automated) have passed.
- The feature is committed and pushed to GitHub.
- Proof (screenshot/demo) is recorded.

## Bug Severity Levels
- **Critical**: System crashes, data loss, or core workflows (like Booking or Login) are completely broken. Must fix immediately.
- **Major**: A major feature is malfunctioning, but there is a workaround. Fix in the current sprint.
- **Minor**: UI glitches, typos, or non-essential feature bugs. Can be pushed to the backlog or fixed when convenient.

## Commit Rules
- Use clear and descriptive commit messages (e.g., "Add therapist CRUD functionality").
- Commit frequently, ideally after each completed feature or bug fix.
- **DO NOT** commit `.env`, the `vendor/` directory, `node_modules/`, log files, cache files, or any local machine-specific files.
