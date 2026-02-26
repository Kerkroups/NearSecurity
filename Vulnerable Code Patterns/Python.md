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

## NoSQL injections:  
```
# MongoDB
db.users.find({"email": user_email})  # Safe with parameterization
db.users.find(eval(user_query))       # Dangerous
collection.insert_one(json.loads(user_data))  # Dangerous

# PyMongo with user control
query = {"$where": f"this.username == '{username}'"}
```  

## Code injection & OS Command injection:  
```
- Direct os.system
os.system(f"curl {url}")
os.system("ping " + hostname)

- Subprocess with shell=True
subprocess.call("rm -rf " + directory, shell=True)
subprocess.run(command_string, shell=True)

- Template-based commands
template = "ssh user@{host} 'rm {file}'"
os.system(template.format(host=user_host, file=user_file))

- eval/exec with external input
exec(user_code)
eval(user_expression)
```

## Unsafe pickle deserialization:  
```
- Direct pickle.loads
import pickle
data = pickle.loads(user_input)

- Pickle from untrusted sources
with open(untrusted_file, 'rb') as f:
    obj = pickle.load(f)

- Custom unpickler with object instantiation
class RiskyUnpickler(pickle.Unpickler):
    def find_class(self, module, name):
        return super().find_class(module, name)
```  
