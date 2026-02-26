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
**Vulnerable patterns**:  
- pickle with untrusted data
- yaml.load() without Loader=yaml.SafeLoader
- Unsafe YAML loaders

## Path traversal & Directory traversal:  
```language:python content:".." OR content:"abspath" OR content:"realpath" path:/.*\.py$/ (file OR path OR directory)```  
**Look for**:  
- os.path.join() with unsanitized user input
- Missing path validation
- Unsafe file operations

## Insecure Authentication & Session Management:  
```language:python symbol:password OR symbol:token OR symbol:secret content:"hardcoded" OR content:"password=" OR content:"API_KEY" path:/.*\.py$/```  
**Search for**:  
- Hardcoded credentials
- Weak password hashing
- Missing CSRF tokens
- Weak session identifiers

## XSS in Templates:  
```language:python content:"render_template" OR content:"jinja2" OR content:"|safe" path:/.*\.py$/```  
**Look for**:  
- Template rendering without escaping
- Unsafe template filters
- Direct HTML rendering

## Insecure deserialization with JSON:  
```language:python content:"json.loads(" OR content:"json.load(" path:/.*\.py$/ NOT content:"JSONDecoder"```  
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

Patterns:
- User ID directly from request
- Missing access control
- No permission validation

## Additional information:  
- Combine multiple vulnerability patterns with `OR`
- Use `NOT` to exclude false positives (e.g., `NOT content:"# TODO"`)
- Add `path:` restrictions to focus on specific directories
- Chain searches: Start broad, then refine based on results









