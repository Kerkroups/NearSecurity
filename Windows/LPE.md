## Path and Files:
- ```PATH NOT FOUND```
- ```NAME NOT FOUND```  
Column: Result  
Relation: is
Action: include

## Operation:  
- ```SetSecurutyFile```
Column: Operation  
Relation: is
Action: include

## Uunquoted service paths  


## Additional ProcMon filters:  
Column: User  
Relation: contains  
Value: SYSTEM  

Column: Result  
Relation: is
Action: include
Value: NAME INVALID  

Column: Operation  
Relation: is
Action: include
Value: CreateFile  

Column: Path  
Relation: ends with
Action: include
Value: dll


## Notes:  
- Not every "CreateFile" call leads to load placed DLL. There are many calls that just checks for attributes, permissions, if the file exist and so on.
- Look for "LoadLibraryA" and "LoadLibraryExW" calls. This calls used to load DLL's or EXE files (dynamically load external code modules into running application's memory at runtime).
- Save ProcMon output to CSV file.  
