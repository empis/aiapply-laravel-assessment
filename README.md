# Task Manager - Fullstack Developer Assessment

A simple task management application built with Laravel 12 and Vue 3.

## Tech Stack

- Laravel 12 + Sanctum (API authentication)
- Vue 3 + Vue Router + Axios
- Tailwind CSS v4
- MySQL 8
- Docker

## Quick Start

```bash
git clone <repo-url>
cd assessment-laravel-vue
chmod +x setup.sh
./setup.sh
```

The app will be available at http://localhost:8000

**Test credentials:**
- Email: candidate@example.com
- Password: password

## Assessment Instructions

### Format

- **Duration:** 60 minutes
- **Recording:** Record your screen from start to finish (OBS, Loom, or any tool)
- **Think aloud:** Explain what you plan, why you make decisions, what you search for
- **AI tools:** Use any AI tools you want (Cursor, Copilot, ChatGPT, Claude) — this is encouraged!
- **Commits:** Commit frequently, at least every 15 minutes
- **Completion:** You do NOT need to finish everything. We evaluate your process, not just the result.

### Tasks

Complete in order. Prioritize quality over quantity.

#### 🟢 Task 1: Filtering & Search (Easy)

Add the ability to filter and search tasks on the task list page.

**Requirements:**

- Add a status filter dropdown (All / To Do / In Progress / Done)
- Add a search input that filters tasks by name
- Filtering should work on the API level (not just frontend)
- Both filters should work together

#### 🟡 Task 2: Comments Feature (Medium)

Add a comments system to tasks.

**Requirements:**

- Create a `comments` table (migration) with: body, user_id, task_id, timestamps
- Create Comment model with relationships
- API endpoints: list comments for a task, add a comment
- Vue component showing comments on the task detail page
- Form to add new comments
- Validation on both backend and frontend (body is required, max 1000 chars)

#### 🔴 Task 3: Real-time Notifications (Hard)

Add real-time notifications when someone adds a comment to a task.

**Requirements:**

- Set up Laravel Broadcasting (Pusher or Laravel Reverb)
- Create an event when a comment is created
- Listen for the event on the frontend
- Show a notification/toast when a new comment appears
- Auto-append the new comment without page refresh

### What We Evaluate

1. **Planning & approach** — How you start, do you read code first?
2. **AI tool usage** — How effectively you use AI, quality of prompts, do you verify output?
3. **Code quality** — Structure, naming, edge cases, validation
4. **Speed & prioritization** — How far you got, smart tradeoffs
5. **Communication** — Think aloud clarity, explaining decisions
6. **Problem-solving** — How you handle blockers and debugging

### Submission

1. Push your code to a new branch
2. Share the screen recording link
3. That's it!

Good luck! 🚀
