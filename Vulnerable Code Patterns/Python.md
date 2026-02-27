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

## Unsafe pickle and YAML deserialization:  
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

```
# Vulnerable:
import yaml
data = yaml.load(user_yaml)
config = yaml.unsafe_load(config_string)

# Safe:
data = yaml.safe_load(user_yaml)
data = yaml.load(user_yaml, Loader=yaml.SafeLoader)
```

## Unsafe JSON deserialization:  
```
# Vulnerable custom JSON decoder
class BadDecoder(json.JSONDecoder):
    def decode(self, s):
        obj = super().decode(s)
        if 'py_type' in obj:
            return eval(f"({obj['py_type']})({obj['value']})")
        return obj

# Object instantiation from JSON
user_obj = json.loads(data, cls=CustomObjectDecoder)
```

## Weak session management:  
```
# Predictable session IDs
session_id = str(user_id) + str(timestamp)
session_token = f"{user_id}-{random.randint(1, 1000)}"

# Session fixation vulnerability
request.session['user_id'] = user_id
request.session.create()  # No session regeneration after login

# Missing secure flags
response.set_cookie('session', session_id)  # Missing secure, httponly
```

## IDOR:  
```
# Vulnerable: No ownership check
@app.route('/api/documents/<int:doc_id>')
def get_document(doc_id):
    doc = Document.query.get(doc_id)
    return jsonify(doc.to_dict())

# Vulnerable: Insufficient authorization
@app.route('/user/<int:user_id>/settings')
def user_settings(user_id):
    user = User.query.get(user_id)
    return render_template('settings.html', user=user)
```

## Path traversal:  
```
# Vulnerable: No path normalization
file_path = "/uploads/" + request.args.get('file')
with open(file_path, 'r') as f:
    return f.read()

# Vulnerable: Insufficient validation
user_path = request.form.get('path')
if '../' not in user_path:
    open(user_path).read()

# Vulnerable: After normalization bypass
path = request.args.get('path').replace('..', '')
open(f"/files/{path}").read()
```

## SSTI:  
```
# SSTI in Jinja2
template_string = request.args.get('template')
template = jinja2.Template(template_string)
return template.render(data=data)

# SSTI with render_template_string
user_template = request.form.get('custom_template')
return render_template_string(user_template)

# Unsafe template filtering
@app.route('/search')
def search():
    query = request.args.get('q')
    return render_template('search.html', query=query)
```

## SSRF & XXE:  
```
# Direct URL from user input
import requests
url = request.args.get('url')
response = requests.get(url)

# SSRF through webhook/callback
webhook_url = request.form.get('webhook')
requests.post(webhook_url, json=data)

# File protocol exposure
file_url = f"file://{request.args.get('path')}"
content = requests.get(file_url).text
```

```
# Vulnerable: XXE enabled
import xml.etree.ElementTree as ET
tree = ET.parse(user_xml_file)

# Vulnerable: External DTD processing
from lxml import etree
parser = etree.XMLParser()
tree = etree.parse(user_xml, parser)

# Vulnerable: No XXE protection
import defusedxml.ElementTree as DET
tree = DET.parse(user_xml)  # Incorrect - might be old version
```

## TOCTOU & Race condition:  
```
# Check-Then-Act vulnerability
if os.path.exists(file_path):
    data = open(file_path).read()  # File might be deleted between check and read

# File TOCTOU
if os.access(filename, os.W_OK):
    os.rename(filename, backup_name)  # File permissions might change
```
