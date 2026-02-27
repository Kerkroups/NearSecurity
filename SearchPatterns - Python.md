## SQL injection:  
```language:python content:"format(" OR content:"%" OR content:"concat" path:/.*\.py$/ (database OR query OR sql)```  

**Direct string formatting in database queries**:  
```language:python content:"SELECT" content:"format(" OR content:"+{" OR content:"f\"" path:/.*\.py$/```  

**String concatenation with database operations**:  
```language:python content:"execute" OR content:"query" content:"+" OR content:"%" path:/.*\.py$/ (db OR database OR cursor)```  

**Raw SQL with user input**:  
```language:python content:"raw(" OR content:"cursor.execute" OR content:"engine.execute" path:/.*\.py$/ NOT content:"?"```  

**Django ORM vulnerabilities**:  
```language:python content:"filter(" OR content:"exclude(" content:"f\"" OR content:"format(" path:/.*\.py$/ (django)```  

**SQLAlchemy raw SQL injection**:  
```language:python content:"text(" OR content:"literal_column" content:"f\"" OR content:"format(" path:/.*\.py$/```  

``` 
language:python (
  content:"\.raw(" OR
  content:"\.filter(" OR
  content:"cursor.execute("
) (
  content:"f\"" OR
  content:"format(" OR
  content:"%" OR
  content:"+"
) path:/.*\.py$/ NOT content:"?" NOT content:"params"
```  

- Direct string concatenation in SQL queries  
- Use of .format() or % formatting with user input

## NoSQL injection:  
**MongoDB with eval**:  
```language:python content:"eval(" OR content:"exec(" content:"find(" OR content:"insert_one(" path:/.*\.py$/```

**$where operator usage**:  
```language:python content:"$where" OR content:"mapReduce" path:/.*\.py$/ (mongodb OR mongo)```  

**Unparameterized NoSQL queries**:  
```language:python content:".find(" OR content:".insert_one(" content:"f\"" OR content:"+" path:/.*\.py$/ (mongo OR nosql)```  

**Unsafe aggregation pipelines**:  
```language:python content:"aggregate(" OR content:"pipeline" content:"$lookup" content:"f\"" OR content:"format(" path:/.*\.py$/```  

## Command Injection & OS Command Injection:  
```language:python symbol:system OR symbol:exec OR symbol:eval OR symbol:subprocess content:"shell=True" OR content:"os.system" OR content:"eval(" OR content:"exec("```  

**os.system with formatting**:  
```language:python content:"os.system(" content:"f\"" OR content:"format(" OR content:"%" OR content:"+" path:/.*\.py$/```  

**subprocess.call/run with shell=True**:  
```language:python content:"subprocess" content:"shell=True" path:/.*\.py$/ NOT content:"# safe" NOT content:"args=["```  

**popen with shell=True**:  
```language:python content:"popen(" OR content:"Popen(" content:"shell=True" path:/.*\.py$/```

**eval and exec usage**:  
```language:python symbol:eval OR symbol:exec path:/.*\.py$/ NOT content:"__pycache__"```  

**Dangerous template-based commands**:  
```language:python content:"\.format(" OR content:"f\"" content:"system" OR "subprocess" OR "popen" path:/.*\.py$/```  

**Shell builtin exposure**:  
```language:python content:"__import__" OR content:"exec(" OR content:"eval(" path:/.*\.py$/ (command OR shell OR bash)```  

**High-risk functions**:  
- os.system()
- subprocess.call() with shell=True
- eval(), exec()
- pickle deserialization

## Unsafe deserialization:  
```language:python content:"pickle.loads" OR content:"pickle.load" OR content:"yaml.load" OR content:"json.loads" path:/.*\.py$/```  

**pickle.loads with user data**:  
```language:python content:"pickle.loads(" OR content:"pickle.load(" path:/.*\.py$/ NOT content:"safe" NOT content:"restricted"```  

**Unsafe pickle usage in APIs**:  
```language:python content:"pickle" content:"request" OR content:"user_input" OR content:"data" path:/.*\.py$/```  

**Custom Unpickler without restrictions**:  
```language:python symbol:Unpickler OR symbol:loads OR symbol:load content:"pickle" path:/.*\.py$/ NOT content:"find_class" NOT content:"RestrictedUnpickler"```  

**Pickle in caching layers**:  
```language:python content:"pickle" content:"cache" OR content:"memcached" OR content:"redis" path:/.*\.py$/```  

**Pickle with file I/O from untrusted paths**:  
```language:python content:"open(" content:"pickle" path:/.*\.py$/ (user_file OR untrusted OR download)```  

**yaml.load without SafeLoader**:  
```language:python content:"yaml.load(" path:/.*\.py$/ NOT content:"Loader=yaml.SafeLoader" NOT content:"Loader=yaml.BaseLoader"```  

**yaml.unsafe_load**:  
```language:python content:"yaml.unsafe_load(" path:/.*\.py$/```  

**yaml with FullLoader in older versions**:  
```language:python content:"yaml.load(" content:"FullLoader" path:/.*\.py$/ NOT content:"safe"```  

**Direct YAML instantiation vulnerability**:  
```language:python content:"!!python" OR content:"!!python/object" path:/.*\.yaml/ OR path:/.*\.yml/```  

**YAML in configuration loading**:  
```language:python content:"yaml.load" OR content:"yaml.unsafe_load" content:"config" OR "settings" OR "conf" path:/.*\.py$/```  

**Vulnerable patterns**:  
- pickle with untrusted data
- yaml.load() without Loader=yaml.SafeLoader
- Unsafe YAML loaders

## Path traversal & Directory traversal:  
```language:python content:".." OR content:"abspath" OR content:"realpath" path:/.*\.py$/ (file OR path OR directory)```  

```
# Find all file operations
language:python (
  symbol:open OR
  symbol:read OR
  symbol:write OR
  symbol:delete_file
) path:/.*\.py$/

# Find file operations with user input
language:python (
  content:"open(" OR
  content:"\.read(" OR
  content:"\.write("
) (
  content:"request\." OR
  content:"user_input" OR
  content:"parameter"
) path:/.*\.py$/ (
  NOT content:"abspath" AND
  NOT content:"realpath" AND
  NOT content:"normpath" AND
  NOT content:"resolve"
)

# Find path concatenation vulnerabilities
language:python (
  content:"f\"" OR
  content:"format(" OR
  content:"+"
) (
  content:"/uploads" OR
  content:"/files" OR
  content:"/data" OR
  content:"/home"
) path:/.*\.py$/ (
  content:"request" OR
  content:"user" OR
  content:"parameter"
)
```

**Direct file access with user input**:  
```language:python content:"open(" content:"request" OR "user_input" OR "parameter" path:/.*\.py$/ NOT content:"abspath" NOT content:"realpath" NOT content:"normpath"```  

**Path concatenation without validation**:  
```language:python content:"+" OR content:"f\"" content:"/uploads" OR "/files" OR "/data" path:/.*\.py$/ (request OR user OR parameter)```  

**Insufficient path traversal prevention**:  
```language:python content:"replace" OR content:"split" content:".." path:/.*\.py$/ NOT content:"abspath" NOT content:"commonpath" NOT content:"realpath"```  

**Using basename on user path (incomplete fix)**:  
```language:python content:"basename(" content:"open(" OR content:"read" path:/.*\.py$/ NOT content:"abspath"```  

**Missing directory validation**:  
```language:python content:"open(" OR content:"read" path:/.*\.py$/ NOT content:"startswith" NOT content:"in_directory" NOT content:"validate_path"```  

**Symlink following vulnerability**:  
```language:python content:"open(" OR content:"isfile(" content:"follow_symlinks=True" OR content:"os.symlink" path:/.*\.py$/```  

**Look for**:  
- os.path.join() with unsanitized user input
- Missing path validation
- Unsafe file operations

## SSRF & XXE:  
**requests.get with user URL**:  
```language:python content:"requests.get(" OR content:"requests.post(" content:"request\." path:/.*\.py$/ NOT content:"validate_url" NOT content:"whitelist"```  

**urllib with user input**:  
```language:python content:"urllib" OR content:"urlopen" content:"request\." path:/.*\.py$/ NOT content:"validate" NOT content:"allowed"```  

**Webhook/callback URL from user**:  
```language:python content:"webhook" OR content:"callback" OR content:"notify_url" content:"request\." path:/.*\.py$/ NOT content:"whitelist" NOT content:"validate_url"```  

**File protocol usage**:  
```language:python content:"file://" OR content:"gopher://" OR content:"dict://" path:/.*\.py$/ (requests OR urllib OR fetch)```  

**Missing URL scheme validation**:  
```language:python content:"requests" content:"http" OR "https" path:/.*\.py$/ NOT content:"scheme" NOT content:"startswith" NOT content:"whitelist"```  

**Unsafe XML parsing**:  
```language:python content:"ElementTree.parse(" OR content:"xml.parse(" OR content:"etree.parse(" path:/.*\.py$/ NOT content:"defusedxml" NOT content:"XMLParser"```  

**lxml without XXE protection**:  
```language:python content:"lxml" content:"parse(" path:/.*\.py$/ NOT content:"defusedxml" NOT content:"XMLParser(remove_blank_text=True)"```  

**DTD processing enabled**:  
```language:python content:"DTD" OR content:"ENTITY" content:"xml" path:/.*\.py$/ NOT content:"disable"```  

**Unsafe XML deserialization**:  
```language:python content:"xml" OR content:"ElementTree" content:"loads(" OR content:"load(" path:/.*\.py$/ NOT content:"defusedxml"```  

**Missing defusedxml import**:  
```language:python content:"ElementTree" OR content:"lxml" OR content:"minidom" path:/.*\.py$/ NOT content:"defusedxml"```  

## Insecure Authentication & Session Management:  
```language:python symbol:password OR symbol:token OR symbol:secret content:"hardcoded" OR content:"password=" OR content:"API_KEY" path:/.*\.py$/```  
**Search for**:  
- Hardcoded credentials
- Weak password hashing
- Missing CSRF tokens
- Weak session identifiers

## SSTI:  
```language:python content:"render_template" OR content:"jinja2" OR content:"|safe" path:/.*\.py$/```  

**Template from user input**:  
```language:python content:"Template(" OR content:"render_template_string(" content:"request" path:/.*\.py$/ NOT content:"escape" NOT content:"quote"```  

**render_template with user content**:  
```language:python content:"render_template(" content:"request\." OR "user" path:/.*\.py$/ NOT content:"escape" NOT content:"quote" NOT content:"safe"```  

**Jinja2 unsafe environment**:  
```language:python content:"jinja2.Environment(" content:"autoescape=False" OR content:"autoescape = False" path:/.*\.py$/```  

**Direct template variable injection**:  
```language:python content:"render" content:"f\"{" OR "f'" content:"user" OR "request" path:/.*\.py$/ (jinja OR template)```  

**Missing context escaping**:  
```language:python content:"render_template(" path:/.*\.py$/ NOT content:"escape" NOT content:"markupsafe" NOT content:"|quote"```  

**Look for**:  
- Template rendering without escaping
- Unsafe template filters
- Direct HTML rendering

## Insecure deserialization with JSON:  
```language:python content:"json.loads(" OR content:"json.load(" path:/.*\.py$/ NOT content:"JSONDecoder"```  

**Custom JSONDecoder with object creation**:  
```language:python symbol:JSONDecoder content:"json.loads" path:/.*\.py$/ NOT content:"dict" NOT content:"parse_int"```  

**eval/exec within JSON processing**:  
```language:python content:"json.load" OR content:"json.loads" content:"eval(" OR content:"exec(" path:/.*\.py$/```  

**Object instantiation from JSON**:  
```language:python content:"json.loads" content:"__init__" OR content:"__new__" OR content:"__call__" path:/.*\.py$/```  

**Unsafe object_hook in JSON**:  
```language:python content:"object_hook=" path:/.*\.py$/ NOT content:"dict" NOT content:"default_hook"```  

**Check for**:  
- Custom JSON decoders with object instantiation
- Unsafe object creation from JSON

## Missing input validation:  
```language:python content:"request.args" OR content:"request.form" OR content:"request.json" path:/.*\.py$/ NOT content:"validate" NOT content:"sanitize"```  
**Patterns**:
- Unvalidated user inputs
- Missing type checking
- Lack of boundary validation

## Unsafe Regular Expression:  
```language:python symbol:compile OR symbol:match OR symbol:search content:".*" path:/.*\.py$/ NOT content:"re.compile"```  
**Look for**:  
- Complex regexes with backtracking
- User-controlled regex patterns
- Nested quantifiers

## Missing TLS validation:  
```language:python content:"verify=False" OR content:"check_hostname=False" OR content:"ssl._create_unverified_context" path:/.*\.py$/```  
**Check for**:  
- Disabled certificate verification
- HTTPS bypass
- Insecure SSL configurations

## Insecure Logging:  
```language:python content:"print(" OR content:"logging" content:"password" OR content:"token" OR content:"secret" OR content:"api_key" path:/.*\.py$/```  

## TOCTOU & Race Condition:  
```language:python content:"os.path.exists" OR content:"os.remove" OR content:"os.rename" path:/.*\.py$/```  

**exists then open**:  
```language:python content:"os.path.exists(" content:"open(" path:/.*\.py$/ NOT content:"try" NOT content:"except"```  

**access check then operation**:  
```language:python content:"os.access(" path:/.*\.py$/ NOT content:"try" NOT content:"except"```  

**Multiple file operations without atomicity**:  
```language:python content:"os.rename(" OR content:"os.remove(" path:/.*\.py$/ NOT content:"try" NOT content:"atomic"```  

**Check before delete vulnerability**:  
```language:python content:"isfile" OR content:"exists" content:"remove" OR "unlink" path:/.*\.py$/```  

**Search for**:  
- Check-then-act patterns
- File operation races
- Time-of-check to time-of-use bugs

## IDOR:  
```language:python content:"user_id" OR content:"request.args" path:/.*\.py$/ NOT content:"authorization" NOT content:"permission"```  
**Patterns**:
- User ID directly from request
- Missing access control
- No permission validation

Now I'll provide you with comprehensive advanced search request patterns for finding vulnerabilities in Python code using lexical-code-search:

## Advanced Search Patterns for Python Vulnerabilities

### 1. **SQL Injection Vulnerabilities**
```
language:python content:"format(" OR content:"%" OR content:"concat" path:/.*\.py$/ (database OR query OR sql)
```

Common vulnerable patterns:
- Direct string concatenation in SQL queries
- Use of `.format()` or `%` formatting with user input
- Unparametrized queries

### 2. **Command Injection & OS Command Execution**
```
language:python symbol:system OR symbol:exec OR symbol:eval OR symbol:subprocess content:"shell=True" OR content:"os.system" OR content:"eval(" OR content:"exec("
```

High-risk functions:
- `os.system()`
- `subprocess.call()` with `shell=True`
- `eval()`, `exec()`
- `pickle` deserialization

### 3. **Unsafe Deserialization**
```
language:python content:"pickle.loads" OR content:"pickle.load" OR content:"yaml.load" OR content:"json.loads" path:/.*\.py$/
```

Vulnerable patterns:
- `pickle` with untrusted data
- `yaml.load()` without `Loader=yaml.SafeLoader`
- Unsafe YAML loaders

### 4. **Path Traversal & Directory Traversal**
```
language:python content:".." OR content:"abspath" OR content:"realpath" path:/.*\.py$/ (file OR path OR directory)
```

Look for:
- `os.path.join()` with unsanitized user input
- Missing path validation
- Unsafe file operations

### 5. **Insecure Authentication & Session Management**
```
language:python symbol:password OR symbol:token OR symbol:secret content:"hardcoded" OR content:"password=" OR content:"API_KEY" path:/.*\.py$/
```  

```
language:python (
  content:"sk_live_" OR
  content:"sk_test_" OR
  content:"AKIA" OR
  content:"aws_secret" OR
  content:"api_key" OR
  content:"API_KEY"
) path:/.*\.py$/ (
  NOT content:"os.environ" AND
  NOT content:"config" AND
  NOT content:"getenv" AND
  NOT is:generated
)

# Find AWS credential patterns
language:python (
  content:"AWS_ACCESS_KEY" OR
  content:"AWS_SECRET_KEY" OR
  content:"aws_access_key_id"
) path:/.*\.py$/ NOT content:"test" NOT content:"mock"

# Find database connection strings
language:python (
  content:"postgresql://" OR
  content:"mysql://" OR
  content:"mongodb://"
) path:/.*\.py$/ (
  NOT content:"example" AND
  NOT content:"test" AND
  NOT content:"localhost"
)
```

```
# Find all authentication decorators and functions
language:python (
  symbol:login OR
  symbol:authenticate OR
  symbol:verify_token OR
  symbol:check_auth
) path:/.*\.py$/

# Find authentication logic without rate limiting
language:python content:"login" OR content:"authenticate" (
  NOT content:"rate_limit" AND
  NOT content:"throttle" AND
  NOT content:"attempt" AND
  NOT content:"cooldown"
) path:/.*\.py$/

# Find CSRF protection validation
language:python (
  content:"csrf" AND
  NOT content:"csrf_token" AND
  NOT content:"validate_csrf"
) path:/.*\.py$/ (view OR route OR handler)

# Find session management issues
language:python (
  content:"request.session" OR
  content:"session\["
) (
  NOT content:"login_required" AND
  NOT content:"authenticate" AND
  NOT content:"permission"
) path:/.*\.py$/
```

Search for:
- Hardcoded credentials
- Weak password hashing
- Missing CSRF tokens
- Weak session identifiers

### 6. **Cryptographic Weaknesses**
```
language:python content:"md5" OR content:"sha1" OR content:"random.random" OR content:"secrets=" path:/.*\.py$/
```

Vulnerable patterns:
- MD5/SHA1 for password hashing
- Weak random number generation
- Missing salt in hashing

### 7. **Cross-Site Scripting (XSS) in Templates**
```
language:python content:"render_template" OR content:"jinja2" OR content:"|safe" path:/.*\.py$/
```

Look for:
- Template rendering without escaping
- Unsafe template filters
- Direct HTML rendering

### 8. **Insecure Deserialization with JSON**
```
language:python content:"json.loads(" OR content:"json.load(" path:/.*\.py$/ NOT content:"JSONDecoder"
```

Check for:
- Custom JSON decoders with object instantiation
- Unsafe object creation from JSON

### 9. **Missing Input Validation**
```
language:python content:"request.args" OR content:"request.form" OR content:"request.json" path:/.*\.py$/ NOT content:"validate" NOT content:"sanitize"
```

Patterns:
- Unvalidated user inputs
- Missing type checking
- Lack of boundary validation

### 10. **Unsafe Regular Expressions (ReDoS)**
```
language:python symbol:compile OR symbol:match OR symbol:search content:".*" path:/.*\.py$/ NOT content:"re.compile"
```

Look for:
- Complex regexes with backtracking
- User-controlled regex patterns
- Nested quantifiers

### 11. **Dependency Vulnerabilities**
```
language:python path:requirements.txt OR path:setup.py OR path:Pipfile content:"==" NOT content:">="
```

Identify:
- Pinned old versions
- Known vulnerable packages
- Missing security patches

### 12. **Missing SSL/TLS Verification**
```
language:python content:"verify=False" OR content:"check_hostname=False" OR content:"ssl._create_unverified_context" path:/.*\.py$/
```

Check for:
- Disabled certificate verification
- HTTPS bypass
- Insecure SSL configurations

### 13. **Information Disclosure & Logging Issues**
```
language:python content:"print(" OR content:"logging" content:"password" OR content:"token" OR content:"secret" OR content:"api_key" path:/.*\.py$/
```

```
# Find verbose logging of sensitive operations
language:python (
  content:"logger" OR
  content:"logging" OR
  content:"print"
) (
  content:"password" OR
  content:"secret" OR
  content:"token" OR
  content:"credit_card" OR
  content:"ssn" OR
  content:"pii"
) path:/.*\.py$/

# Find unhandled exceptions exposing stack traces
language:python (
  content:"except Exception" OR
  content:"except:" OR
  content:"except BaseException"
) (
  content:"return.*str(e)" OR
  content:"jsonify" AND content:"error"
) path:/.*\.py$/

# Find debug mode enabled in configuration
language:python (
  content:"DEBUG" OR
  content:"TESTING" OR
  content:"development"
) path:/.*\.py$/ (
  content:"True" OR
  content:"= True" OR
  content:"== True"
) NOT content:"if" NOT content:"and" NOT content:"or"
```

Look for:
- Sensitive data in logs
- Debug mode enabled in production
- Stack trace exposure

### 14. **Race Conditions & TOCTOU**
```
language:python content:"os.path.exists" OR content:"os.remove" OR content:"os.rename" path:/.*\.py$/
```

Search for:
- Check-then-act patterns
- File operation races
- Time-of-check to time-of-use bugs

### 15. **Insecure Direct Object Reference (IDOR)**
```
language:python content:"user_id" OR content:"request.args" path:/.*\.py$/ NOT content:"authorization" NOT content:"permission"
```
**Direct query by user-controlled ID without authorization**:
```language:python content:".get(" OR content:".query.get(" content:"user_id" OR content:"id" path:/.*\.py$/ NOT content:"current_user" NOT content:"permission" NOT content:"authorize"```  

**Route handler with ID parameter missing access check**:  
```language:python content:"@app.route" OR content:"@route" content:"<int:" OR content:"<string:" path:/.*\.py$/ NOT content:"authorize" NOT content:"permission_required" NOT content:"current_user"```  

**Resource access without ownership verification**:  
```language:python content:"Document.query" OR content:"File.query" OR content:"Resource.query" content:".get(" path:/.*\.py$/ NOT content:"user_id" NOT content:"owner" NOT content:"permission"```  

**UUID/sequential ID enumeration risk**:  
```language:python content:"@app.route" content:"/api/" content:"<uuid:" OR content:"<int:" path:/.*\.py$/ NOT content:"@login_required" NOT content:"@permission"```  

**Missing organization boundary checks**:  
```language:python content:"Organization.query" OR content:"Team.query" content:".user" OR content:".member" path:/.*\.py$/ NOT content:"org_id" NOT content:"current_org"```  

Patterns:
- User ID directly from request
- Missing access control
- No permission validation

## Additional information:  
- Combine multiple vulnerability patterns with `OR`
- Use `NOT` to exclude false positives (e.g., `NOT content:"# TODO"`)
- Add `path:` restrictions to focus on specific directories
- Chain searches: Start broad, then refine based on results


## Fast search patterns:  
```
# Scan entire organization for critical vulnerabilities
language:python (
  content:"eval(" OR 
  content:"exec(" OR 
  content:"os.system(" OR 
  content:"subprocess.call" OR 
  content:"pickle.loads"
) path:/.*\.py$/ NOT is:archived NOT is:fork

# Expected scope: 50-500+ results depending on org size
# Recommended: Review top 100 results manually
```

**Dependncy**:  
```
# Find potentially vulnerable package usage
(path:requirements.txt OR path:setup.py OR path:pyproject.toml) 
content:"django" OR content:"flask" OR content:"jinja2" 
NOT content:">=" NOT content:"~="
```

**Database access security review**:  
```
# Find all database operations for SQL injection audit
language:python (
  content:"execute(" OR 
  content:"query(" OR 
  content:"select(" OR 
  content:"filter("
) (
  content:"format(" OR 
  content:"f\"" OR 
  content:"f'" OR 
  content:"+" OR 
  content:"%"
) path:/.*\.py$/ NOT content:"parameterized" NOT content:"ORM"
```

**Cryptography**:  
```
# Find all cryptographic operations and secret handling
language:python (
  content:"hashlib" OR 
  content:"crypto" OR 
  content:"password" OR 
  content:"SECRET" OR 
  content:"API_KEY" OR 
  content:"token"
) (
  content:"=" NOT content:"os.environ" NOT content:"config" NOT content:"getenv"
) path:/.*\.py$/
```  





