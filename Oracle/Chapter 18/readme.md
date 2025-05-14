```
CREATE PROFILE C##LIMITED_PROFILE 
LIMIT
    PASSWORD_LIFE_TIME 10
    PASSWORD_GRACE_TIME 8
    PASSWORD_REUSE_MAX 3
    PASSWORD_LOCK_TIME 1
    FAILED_LOGIN_ATTEMPTS 2
    PASSWORD_REUSE_TIME 10;
```

## 🔐 Oracle Password Profile Settings 

---

### ✅ 1. `PASSWORD_LIFE_TIME 10`

**মানে:**
একটা পাসওয়ার্ড সর্বোচ্চ **১০ দিন** পর্যন্ত ব্যবহার করা যাবে। তারপর সেটা **expired** হয়ে যাবে।

🧪 **যেভাবে চেক করবে:**

1. ইউজার তৈরি করো (যেমন: `c##test`)
2. লগইন করো
3. কম্পিউটারের তারিখ ১০ দিন এগিয়ে দাও
4. আবার লগইন করলে দেখাবে:

   ```
   ORA-28002: the password will expire within 8 days
   ```

   এরপর ১০ দিন পার হলে দেখাবে:

   ```
   ORA-28001: the password has expired
   ```

---

### ✅ 2. `PASSWORD_GRACE_TIME 8`

**মানে:**
Password expired হবার পরেও ইউজার **৮ দিন সময়** পাবে নতুন পাসওয়ার্ড সেট করার জন্য। এটাকে বলা হয় Grace Period.

🧪 **যেভাবে চেক করবে:**

1. `PASSWORD_LIFE_TIME` শেষ হবার পর লগইন করো
2. তখন ওয়ার্নিং দিবে নতুন পাসওয়ার্ড দিতে 
3. দেখাবে:

   ```
   ORA-28002: the password will expire within 8 days
   ```

   
❗ **যদি এই ৮ দিনের মধ্যে পাসওয়ার্ড না পাল্টানো হয়:**

```
ORA-28001: the password has expired
```

🔒 ইউজার আর লগইন করতে পারবে না।

✅ **তখন অ্যাডমিনকে পাসওয়ার্ড চেঞ্জ করতে হবে:**

এরপর:

   ```
   New password:
   Retype new password:
   ```

অথবা 

```sql
ALTER USER c##test IDENTIFIED BY new_password;
```

---

### ✅ 3. `PASSWORD_REUSE_MAX 3`

**মানে:**
একবার ব্যবহৃত পাসওয়ার্ড আবার ব্যবহার করতে হলে **কমপক্ষে ৩টি নতুন পাসওয়ার্ড ব্যবহার করতে হবে।**

🧪 **যেভাবে চেক করবে:**

1. 1st password → `mehedi`
2. তারপর → `abid`, `taher`, `sadman`
3. এখন আবার `mehedi` দিলে – **সেট হবে**

❌ কিন্তু `mehedi` আবার ২টা নতুন পাসের পরে দিলে:

```
ORA-28007: the password cannot be reused
```

---

### ✅ 4. `PASSWORD_REUSE_TIME 10`

**মানে:**
যে পাসওয়ার্ড ১০ দিনের মধ্যে ব্যবহার হয়েছে, সেটা আবার **ব্যবহার করা যাবে না।**

🧪 **যেভাবে চেক করবে:**

1. আজ `mehedi` দিলে, পরবর্তী ১০ দিন পর্যন্ত `mehedi` আবার দিলে Error দেখাবে
2. ১০ দিন পর আবার `mehedi` দিলে – **সেট হবে**

---

### ✅ 5. `FAILED_LOGIN_ATTEMPTS 2`

**মানে:**
ইউজার ভুল পাসওয়ার্ডে **২ বার চেষ্টা করলে** অ্যাকাউন্ট **লক** হয়ে যাবে।

🧪 **যেভাবে চেক করবে:**

1. ভুল পাসওয়ার্ড ২ বার দাও
2. তারপর দেখাবে:

```
ORA-28000: the account is locked
```

---

### ✅ 6. `PASSWORD_LOCK_TIME 1`

**মানে:**
একবার অ্যাকাউন্ট লক হলে **১ দিন পর** আবার unlock হবে।

🧪 **যেভাবে চেক করবে:**

* ইউজার লক হলে পরদিন try করলে আবার লগইন হবে
* অথবা টাইম এগিয়ে দিয়ে test করতে পারো

🔓 **ম্যানুয়ালি আনলক করতে:**

```sql
ALTER USER c##test ACCOUNT UNLOCK;
```

---

## 🧠 Summary Table:

| Parameter               | মান    | সহজ ব্যাখ্যা                                        |
| ----------------------- | ------ | --------------------------------------------------- |
| `PASSWORD_LIFE_TIME`    | 10 দিন | পাসওয়ার্ড ১০ দিন পর্যন্ত valid                      |
| `PASSWORD_GRACE_TIME`   | 8 দিন  | Expired পাসওয়ার্ডে ৮ দিনের মধ্যে change করতে হবে    |
| `PASSWORD_REUSE_MAX`    | 3      | সর্বশেষ ৩টা পাসওয়ার্ড পুনঃব্যবহার করা যাবে না       |
| `PASSWORD_REUSE_TIME`   | 10 দিন | ১০ দিনের মধ্যে ব্যবহৃত পাসওয়ার্ড আবার দেওয়া যাবে না |
| `FAILED_LOGIN_ATTEMPTS` | 2 বার  | ভুল পাস ২ বার দিলে অ্যাকাউন্ট লক                    |
| `PASSWORD_LOCK_TIME`    | 1 দিন  | লক হলে ১ দিন পর আবার try করা যাবে                   |

---

