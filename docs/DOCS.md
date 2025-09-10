# 🎮 Game Leaderboard API

All endpoints return JSON in the format:

```json
{
  "success": true,
  "data": { ... }
}
```

Errors look like this:

```json
{
  "success": false,
  "data": {
    "message": "Error description",
    "errors": { ... }   
  }
}
```

# 👤 Tenants
## Get tenant info for the authenticated API key.
#### `GET /api/tenants/me`

**Query:**

```
/api/tenants/me
```

**Response (200):**

```json
{
  "success": true,
  "data": {
    "tenant_info": {
      "id": 1,
      "name": "Tenant One",
      "email": "tenant1@example.com",
      "plan": "pro",
      "active": true,
      "created_at": "2025-09-05T14:57:32.000000Z",
      "updated_at": "2025-09-05T14:57:32.000000Z",
      "api_key": "123456",
      "api_secret": "123456abcd"
    }
  }
}
```

---

# 🎮 Games
## List all games for the tenant.
#### `GET /api/games`



**Query:**

```
/api/games
```

**Response (200):**

```json
{
  "success": true,
  "data": {
    "games": [
      {
        "id": 1,
        "tenant_id": 1,
        "name": "My First Game",
        "slug": "my-first-game",
        "leaderboard_count": 1
      }
    ]
  }
}
```

---
## Create a new game.
#### `POST /api/games/submit`



**Query:**

```
/api/games/submit?name=New%20Game&slug=new-game
```

**Response (201):**

```json
{
  "success": true,
  "data": {
    "created_game": {
      "tenant_id": 1,
      "name": "Test1Game",
      "slug": "test1-game",
      "updated_at": "2025-09-05T16:19:24.000000Z",
      "created_at": "2025-09-05T16:19:24.000000Z",
      "id": 1
    }
  }
}
```

---
## Delete a game.
#### `DELETE /api/games/delete`



**Query:**

```
/api/games/delete?id=1
```

**Response (200):**

```json
{
  "success": true,
  "data": {
    "deleted_game": {
      "id": 1,
      "tenant_id": 1,
      "name": "Test1Game",
      "slug": "test1-game",
      "created_at": "2025-09-05T16:23:18.000000Z",
      "updated_at": "2025-09-05T16:23:18.000000Z"
    }
  }
}
```

---
## List all leaderboards for a game.
#### `GET /api/games/leaderboards`



**Query:**

```
/api/games/leaderboards?id=1
```

**Response (200):**

```json
{
  "success": true,
  "data": {
    "leaderboards": [
      {
        "id": 1,
        "game_id": 1,
        "name": "Leaderboard One",
        "mode": "BEST",
        "created_at": "2025-09-05T14:57:32.000000Z",
        "updated_at": "2025-09-05T14:57:32.000000Z"
      }
    ]
  }
}
```

---

# 🏆 Leaderboards
## Get top 10 scores for a leaderboard.
#### `GET /api/leaderboard`



**Query:**

```
/api/leaderboard?id=1
```

**Response (200):**

```json
{
  "success": true,
  "data": {
    "top_ten_scores": [
      {"player_name": "A", "score_value": 3, "tries": 1},
      {"player_name": "B", "score_value": 2, "tries": 1},
      {"player_name": "C", "score_value": 1, "tries": 1}
    ]
  }
}
```

---
## Create a new leaderboard.
#### `POST /api/leaderboard/submit`



**Query:**

```
/api/leaderboard/submit?game_id=1&name=Speedrun%20Leaderboard&mode=BEST
```

**Response (201):**

```json
{
  "success": true,
  "data": {
    "created_leaderboard": {
      "game_id": 1,
      "name": "Speedrun Leaderboard",
      "mode": "BEST",
      "updated_at": "2025-09-05T16:26:56.000000Z",
      "created_at": "2025-09-05T16:26:56.000000Z",
      "id": 1
    }
  }
}
```

---
## Delete a leaderboard.
#### `DELETE /api/leaderboard/delete`



**Query:**

```
/api/leaderboard/delete?id=1
```

**Response (200):**

```json
{
  "success": true,
  "data": {
    "deleted_leaderboard": {
      "id": 1,
      "game_id": 1,
      "name": "Speedrun Leaderboard",
      "mode": "BEST",
      "created_at": "2025-09-05T16:26:56.000000Z",
      "updated_at": "2025-09-05T16:26:56.000000Z"
    }
  }
}
```

---
## List all scores for a leaderboard.
#### `GET /api/leaderboard/scores`



**Query:**

```
/api/leaderboard/scores?id=1
```

**Response (200):**

```json
{
  "success": true,
  "data": {
    "all_scores": [
      {
        "player_name": "A",
        "score_value": 1200,
        "tries": 3
      },
      {
        "player_name": "B",
        "score_value": 1000,
        "tries": 19
      },
      {
        "player_name": "C",
        "score_value": 800,
        "tries": 5
      }
    ]
  }
}
```

---
## Get statistics for a leaderboard including total players, top 3 scores, average scores, and average tries.
#### `GET /api/leaderboard/stats`



**Query:**

```
/api/leaderboard/stats?id=1
```

**Response (200):**

```json
{
  "success": true,
  "data": {
    "stats": {
      "totalPlayersCount": 3,
      "topScores": [
        {
          "id": 1,
          "leaderboard_id": 1,
          "player_id": 1,
          "score_value": 1200,
          "created_at": "2025-09-05T14:57:32.000000Z",
          "updated_at": "2025-09-05T14:57:32.000000Z",
          "tries": 3
        },
        {
          "id": 2,
          "leaderboard_id": 1,
          "player_id": 2,
          "score_value": 1000,
          "created_at": "2025-09-05T16:24:51.000000Z",
          "updated_at": "2025-09-05T16:24:51.000000Z",
          "tries": 19
        },
        {
          "id": 3,
          "leaderboard_id": 1,
          "player_id": 3,
          "score_value": 800,
          "created_at": "2025-09-05T16:25:01.000000Z",
          "updated_at": "2025-09-05T16:25:01.000000Z",
          "tries": 5
        }
      ],
      "avgScores": 800,
      "avgTries": 9
    }
  }
}
```

---


# 🧩 Scores
## Submit a score for a player.
#### `POST /api/scores/submit`



**Query:**

```
/api/scores/submit?leaderboard_id=1&player_name=Alice&score_value=2000
```

**Response (200):**

```json
{
  "success": true,
  "data": {
    "submitted_score": {
      "leaderboard_id": 1,
      "player_id": 1,
      "score_value": 2000,
      "updated_at": "2025-09-05T16:30:00.000000Z",
      "created_at": "2025-09-05T16:30:00.000000Z",
      "id": 1
    }
  }
}
```

---
## Delete a player's score.

#### `DELETE /api/scores/delete`

**Query:**

```
/api/scores/delete?id=1
```

**Response (200):**

```json
{
  "success": true,
  "data": {
    "deleted_score": {
      "id": 1,
      "leaderboard_id": 1,
      "player_id": 1,
      "score_value": 2000,
      "created_at": "2025-09-05T16:30:00.000000Z",
      "updated_at": "2025-09-05T16:30:00.000000Z"
    }
  }
}
```

---


# 👤 Players
## Get all scores for a specific player.
#### `GET /api/players/scores`



**Query:**

```
/api/players/scores?player_id=1
```

**Response (200):**

```json
{
  "success": true,
  "data": {
    "scores": [
      {
        "game_name": "Speedrunner Game",
        "leaderboard_name": "Speedrun Leaderboard",
        "player_name": "A",
        "score": 1200,
        "tries": 3
      }
    ]
  }
}
```
