

## 🔷 **Oracle SQL Project: Privilege Management – Updated with BOB and JUDY**

---

### ✅ Step 1: `SYSDBA` দিয়ে লগইন করো

```sql
CONNECT SYSTEM/1234;
```

---

### ✅ Step 2: দুইটি ইউজার তৈরি করো

```sql
-- USER: c##BOB (will own the NEWSPAPER table)
CREATE USER c##BOB IDENTIFIED BY BOB;
GRANT CREATE SESSION, CREATE TABLE, CREATE VIEW, CREATE SYNONYM TO c##BOB;

-- USER: c##JUDY (will access the table)
CREATE USER c##JUDY IDENTIFIED BY JUDY;
GRANT CREATE SESSION TO c##JUDY;
```

---

### ✅ Step 3: BOB-এর টেবিল স্পেস কনফিগার করো

```sql
ALTER USER c##BOB
DEFAULT TABLESPACE USERS
QUOTA UNLIMITED ON USERS;
```

---

### ✅ Step 4: BOB দিয়ে লগইন করে টেবিল তৈরি করো ও ডেটা ইনসার্ট করো

```sql
CONNECT c##BOB/BOB;

CREATE TABLE NEWSPAPER (
    FEATURE VARCHAR2(10)
);

INSERT INTO NEWSPAPER VALUES ('SS');
COMMIT;
```

---

### ✅ Step 5: JUDY ইউজারকে NEWSPAPER টেবিলের privilege দাও

```sql
GRANT SELECT, INSERT, UPDATE, DELETE ON NEWSPAPER TO c##JUDY;
```

---

### ✅ Step 6: JUDY দিয়ে লগইন করে BOB-এর টেবিল ব্যবহার করো

```sql
CONNECT c##JUDY/JUDY;

-- BOB ইউজারের টেবিল দেখতে OWNER সহ SELECT করো
SELECT * FROM c##BOB.NEWSPAPER;

-- BOB-এর টেবিলে নতুন তথ্য ইনসার্ট করো
INSERT INTO c##BOB.NEWSPAPER VALUES ('AA');
COMMIT;

-- আবার SELECT করে চেক করো
SELECT * FROM c##BOB.NEWSPAPER;
```

---

### ✅ Output হবে:

```
FEATURE
----------
SS
AA
```

---

### 🔎 Check current user (optional):

```sql
SHOW USER;
-- Output: USER is "C##JUDY"
```

---

এইভাবে তুমি `BOB` এবং `JUDY` নাম দিয়ে সম্পূর্ণ প্রজেক্ট শেষ করতে পারবে 🔥
আরও সাহায্য লাগলে জানিও! ✅
