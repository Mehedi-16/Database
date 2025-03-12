
# Oracle Database User Management and Newspaper Table Operations

This script demonstrates how to create two database users (`C##BOB` and `C##JUDY`), assign appropriate privileges, and perform various operations on a `NEWSPAPER` table in an Oracle database.

## Prerequisites

- Oracle Database with Container Database (CDB) enabled.
- SYSDBA access is required to execute `DROP USER` and `CREATE USER` commands.

## Script Breakdown

### 1. **Dropping Existing Profile**

```sql
DROP PROFILE PROFILE_NAME;
```
- Example:
```sql
DROP PROFILE LIMITED_PROFILE;
```

### 2. **Creating a Profile with New Privileges**

```sql
CREATE PROFILE C##LIMITED_PROFILE 
LIMIT
    PASSWORD_LIFE_TIME 10
    PASSWORD_GRACE_TIME 8
    PASSWORD_REUSE_MAX 3
    PASSWORD_LOCK_TIME 1
    FAILED_LOGIN_ATTEMPTS 2
    PASSWORD_REUSE_TIME UNLIMITED;
```

### 3. **Dropping Existing Users**

```sql
DROP USER C##BOB CASCADE;
DROP USER C##JUDY CASCADE;
```
- This command deletes the users `C##BOB` and `C##JUDY`, along with all their associated objects.

### 4. **Creating Users**

```sql
CREATE USER C##BOB IDENTIFIED BY pizza;
```
```sql
GRANT CREATE SESSION, CREATE TABLE, CREATE SYNONYM TO C##BOB;
```
- This command creates the user `C##BOB` with the password `pizza` and grants them the privileges to create sessions, tables, and synonyms.

```sql
CREATE USER C##JUDY IDENTIFIED BY burger;
```
```sql
GRANT CREATE SESSION TO C##JUDY;
```
- This creates the user `C##JUDY` with the password `burger` and grants them the privilege to create a session only.

### 5. **Creating and Populating the `NEWSPAPER` Table**

```sql
CONNECT C##BOB/pizza;
```

#### Unlimited Quota for `C##JANE`:
```sql
ALTER USER C##jane QUOTA UNLIMITED ON USERS;
```

#### Limit Quota to 100MB for `C##JANE`:
```sql
ALTER USER C##jane QUOTA 100M ON USERS;
```

#### Drop a Table:
```sql
DROP TABLE TABLE_NAME;
```

#### Create the `NEWSPAPER` Table:
```sql
CREATE TABLE NEWSPAPER (
    Feature VARCHAR2(15) NOT NULL,
    Section CHAR(1),
    Page NUMBER
);
```
- Logs in as `C##BOB` and creates the `NEWSPAPER` table with three columns: `Feature`, `Section`, and `Page`.

#### Inserting Sample Data into the `NEWSPAPER` Table:
```sql
INSERT INTO NEWSPAPER VALUES ('National News', 'A', 1);
INSERT INTO NEWSPAPER VALUES ('Sports', 'D', 1);
INSERT INTO NEWSPAPER VALUES ('Editorials', 'A', 12);
INSERT INTO NEWSPAPER VALUES ('Business', 'E', 1);
INSERT INTO NEWSPAPER VALUES ('Weather', 'C', 2);
INSERT INTO NEWSPAPER VALUES ('Television', 'B', 7);
INSERT INTO NEWSPAPER VALUES ('Births', 'F', 7);
INSERT INTO NEWSPAPER VALUES ('Classified', 'F', 8);
INSERT INTO NEWSPAPER VALUES ('Modern Life', 'B', 1);
INSERT INTO NEWSPAPER VALUES ('Comics', 'C', 4);
INSERT INTO NEWSPAPER VALUES ('Movies', 'B', 4);
INSERT INTO NEWSPAPER VALUES ('Bridge', 'B', 2);
INSERT INTO NEWSPAPER VALUES ('Obituaries', 'F', 6);
INSERT INTO NEWSPAPER VALUES ('Doctor Is In', 'F', 6);
```
- Inserts multiple records into the `NEWSPAPER` table for testing.

### 6. **Granting Permissions to `C##JUDY`**

```sql
GRANT SELECT ON NEWSPAPER TO C##JUDY;
```

```sql
GRANT INSERT, UPDATE, DELETE ON NEWSPAPER TO C##JUDY;
```
- Grants `C##JUDY` permission to:
  - **View** the table (via `SELECT`)
  - **Add** new records (via `INSERT`)
  - **Modify** records (via `UPDATE`)
  - **Delete** records (via `DELETE`)

### 7. **Performing CRUD Operations as `C##JUDY`**

```sql
CONNECT C##JUDY/burger;
```

#### Select All Records from `NEWSPAPER`:
```sql
SELECT * FROM C##BOB.NEWSPAPER;
```

#### Insert a New Record into the `NEWSPAPER` Table:
```sql
INSERT INTO C##BOB.NEWSPAPER VALUES ('Mehedi is alive', 'F', 6);
```

#### Update Existing Records in the `NEWSPAPER` Table:
```sql
UPDATE C##BOB.NEWSPAPER
SET FEATURE = 'cat'
WHERE PAGE = 1;
```

#### Delete Records from the `NEWSPAPER` Table:
```sql
DELETE FROM C##BOB.NEWSPAPER
WHERE SECTION = 'D';
```

## Expected Outcome

After running the script:
1. **`C##BOB`** will have a `NEWSPAPER` table populated with sample records.
2. **`C##JUDY`** will be able to:
    - View the table using `SELECT`.
    - Insert new records using `INSERT`.
    - Update existing records using `UPDATE`.
    - Delete records using `DELETE`.

## Notes

- Ensure you have `SYSDBA` privileges before running the script.
- The `CASCADE` option in `DROP USER` ensures that all objects owned by the user are also removed.
- Run each section in order to avoid permission errors.

Happy coding! 🚀
