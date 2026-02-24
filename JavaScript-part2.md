**Чтение локального файла**  
```
import fs from "fs";
const data = fs.readFileSync("test.pdf");
```

**Чтение аргумента коммандной строки как имя локального файла**  
```
import fs from "fs";
const filePath = process.argv[2];
const data = fs.readFileSync(filePath);
```
## Деобфускация JS:  
 - https://obf-io.deobfuscate.io/
 - https://matthewfl.com/unPacker.html


