## SQL injection:

**Dynamic query building**:  
```
# More sophisticated vulnerabilities:
conditions = []
if user_id:
    conditions.append(f"id = {user_id}")
if status:
    conditions.append(f"status = '{status}'")
query = "SELECT * FROM users WHERE " + " AND ".join(conditions)
```

**ORM-based SQL injection**:  
```
# SQLAlchemy, Django ORM vulnerabilities:
User.query.filter(f"username = '{username}'")
users = session.query(User).filter(raw_sql_filter)
```
