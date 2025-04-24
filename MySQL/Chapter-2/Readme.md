
# 1.Employee Database Queries (Relational Algebra)

এই রিপোজিটরিতে বিভিন্ন কুয়েরি এবং তার রিলেশনাল অ্যালজেব্রা এক্সপ্রেশন দেওয়া হয়েছে যা একটি **Employee Database** এর ওপর কাজ করে। ডেটাবেসে নিম্নলিখিত টেবিলগুলো রয়েছে:

- **employee**(e-name, street, city)
- **works**(e-name, c-name, salary)
- **company**(c-name, city)
- **manages**(e-name, m-name)

## Queries and Relational Algebra Expressions

### 1. Find the names, street address, and cities of all employees who work for Rupali Bank and earn more than 50,000 taka per month.
**Query**:  
"রূপালী ব্যাংকে কাজ করা এবং যাদের বেতন ৫০,০০০ টাকার বেশি—তাদের নাম, রাস্তার ঠিকানা এবং শহরের নাম বের করো।"

**Relational Algebra Expression**:
```
∏ e.e-name, e.street, e.city (
  σ w.c-name = 'Rupali Bank' ∧ w.salary > 50000 (
    employee e ⨝ e.e-name = w.e-name works w
  )
)
```

**ব্যাখ্যা**:
1. **employee e ⨝ e.e-name = w.e-name works w**: `employee` এবং `works` টেবিলগুলোকে যোগ করছি যেখানে কর্মচারীর নাম সমান।
2. **σ w.c-name = 'Rupali Bank' ∧ w.salary > 50000 (...)**: সিলেক্ট করছি শুধু সেই রেকর্ড যেখানে কোম্পানি "Rupali Bank" এবং বেতন ৫০,০০০ এর বেশি।
3. **∏ e.e-name, e.street, e.city**: কেবল কর্মচারীর নাম, রাস্তা এবং শহরের তথ্য প্রজেক্ট করছি।

---

### 2. Find the names of all employees who live in the same city as the company for which they work.
**Query**:  
"যেসব কর্মচারী সেই শহরে থাকেন যেই শহরে তাদের কোম্পানি অবস্থিত—তাদের নাম বের করো।"

**Relational Algebra Expression**:
```
∏ e.e-name (
  σ e.city = c.city (
    (employee e ⨝ e.e-name = w.e-name works w) ⨝ w.c-name = c.c-name company c
  )
)
```

**ব্যাখ্যা**:
1. **employee ⨝ works**: `employee` এবং `works` টেবিলগুলোকে যোগ করে কর্মচারীর কাজের তথ্য নিয়ে আসছি।
2. **⨝ company**: এরপর `company` টেবিলের সাথে যোগ করছি কোম্পানির তথ্য পেতে।
3. **σ e.city = c.city**: সিলেক্ট করছি যেখানে কর্মচারী এবং কোম্পানির শহর এক।
4. **∏ e.e-name**: শুধু কর্মচারীর নাম প্রজেক্ট করছি।

---

### 3. Find the names of all employees who live in the same city and on the same street as do their managers.
**Query**:  
"যেসব কর্মচারী তাদের ম্যানেজারের সঙ্গে একই রাস্তা এবং শহরে থাকেন—তাদের নাম বের করো।"

**Relational Algebra Expression**:
```
∏ e.e-name (
  σ e.street = em.street ∧ e.city = em.city (
    (employee e ⨝ e.e-name = m.e-name manages m) ⨝ m.m-name = em.e-name employee em
  )
)
```

**ব্যাখ্যা**:
1. **employee e ⨝ manages m**: `employee` এবং `manages` টেবিলগুলোকে যোগ করছি যাতে কর্মচারী এবং তাদের ম্যানেজারদের নাম একসাথে আসতে পারে।
2. **⨝ employee em**: আবার `employee` টেবিলের সাথে যোগ করছি যাতে ম্যানেজারের তথ্য পাওয়া যায়।
3. **σ e.street = em.street ∧ e.city = em.city**: সিলেক্ট করছি যেখানে কর্মচারী এবং ম্যানেজার একই রাস্তা ও শহরে থাকেন।
4. **∏ e.e-name**: কেবল কর্মচারীর নাম প্রজেক্ট করছি।

---

### 4. Find the names of all employees who do not work for the First Bank Corporation.
**Query**:  
"যারা First Bank Corporation-এ কাজ করে না—তাদের নাম বের করো।"

**Relational Algebra Expression**:
```
∏ e-name (
  σ c-name ≠ 'First Bank Corporation' (works)
)
```

**ব্যাখ্যা**:
1. **σ c-name ≠ 'First Bank Corporation' (works)**: `works` টেবিল থেকে সিলেক্ট করছি যাদের কোম্পানি নাম "First Bank Corporation" নয়।
2. **∏ e-name**: কেবল কর্মচারীর নাম প্রজেক্ট করছি।

---

# 2.Employee Database Queries (Relational Algebra)

This repository contains various queries and their relational algebra expressions working on an **Employee Database**. The database consists of the following tables:

- **employee**(emp-id, emp-name, street, city)
- **works**(emp-id, company-name, salary)
- **company**(company-name, company-city)

## Queries and Relational Algebra Expressions

### a. Find the ID and name of each employee who works for "BigBank".
**Query**:  
"বিগব্যাংকে কাজ করা প্রতিটি কর্মচারীর আইডি এবং নাম বের করো।"

**Relational Algebra Expression**:
```plaintext
∏ emp-id, emp-name (
  σ company-name = 'BigBank' (works)
  ⨝ employee
)
```

**ব্যাখ্যা**:
- **σ company-name = 'BigBank' (works)**: `works` টেবিল থেকে শুধু সেই রেকর্ডগুলো সিলেক্ট করা হচ্ছে যেখানে কোম্পানি "BigBank"।
- **⨝ employee**: এরপর, `works` টেবিলের ফলাফলকে `employee` টেবিলের সাথে `emp-id` ব্যবহার করে যোগ করা হচ্ছে যাতে কর্মচারীর নাম পাওয়া যায়।
- **∏ emp-id, emp-name**: কেবল `emp-id` এবং `emp-name` কলামগুলো প্রজেক্ট করা হচ্ছে।

---

### b. Find the ID, name, and city of residence of each employee who works for "BigBank".
**Query**:  
"বিগব্যাংকে কাজ করা প্রতিটি কর্মচারীর আইডি, নাম এবং বাসার শহর বের করো।"

**Relational Algebra Expression**:
```plaintext
∏ emp-id, emp-name, city (
  σ company-name = 'BigBank' (works)
  ⨝ employee
)
```

**ব্যাখ্যা**:
- **σ company-name = 'BigBank' (works)**: `works` টেবিল থেকে শুধু সেই রেকর্ডগুলো সিলেক্ট করা হচ্ছে যেখানে কোম্পানি "BigBank"।
- **⨝ employee**: `works` টেবিলের সাথে `employee` টেবিল যোগ করা হচ্ছে, যাতে কর্মচারীর নাম এবং শহরের নাম পাওয়া যায়।
- **∏ emp-id, emp-name, city**: কেবল `emp-id`, `emp-name` এবং `city` কলামগুলো প্রজেক্ট করা হচ্ছে।

---

### c. Find the ID, name, street address, and city of residence of each employee who works for "BigBank" and earns more than $10000.
**Query**:  
"বিগব্যাংকে কাজ করা এবং যাদের বেতন $১০,০০০ এর বেশি—তাদের আইডি, নাম, রাস্তার ঠিকানা এবং বাসার শহর বের করো।"

**Relational Algebra Expression**:
```plaintext
∏ emp-id, emp-name, street, city (
  σ company-name = 'BigBank' ∧ salary > 10000 (works)
  ⨝ employee
)
```

**ব্যাখ্যা**:
- **σ company-name = 'BigBank' ∧ salary > 10000 (works)**: `works` টেবিল থেকে সেই রেকর্ডগুলো সিলেক্ট করা হচ্ছে যেখানে কোম্পানি "BigBank" এবং বেতন $১০,০০০ এর বেশি।
- **⨝ employee**: `works` টেবিলের সাথে `employee` টেবিল যোগ করা হচ্ছে, যাতে কর্মচারীর নাম, রাস্তার ঠিকানা এবং শহর পাওয়া যায়।
- **∏ emp-id, emp-name, street, city**: কেবল `emp-id`, `emp-name`, `street` এবং `city` কলামগুলো প্রজেক্ট করা হচ্ছে।

---

### d. Find the ID and name of each employee in this database who lives in the same city as the company for which she or he works.
**Query**:  
"যেসব কর্মচারী তাদের কোম্পানির শহরে থাকেন—তাদের আইডি এবং নাম বের করো।"

**Relational Algebra Expression**:
```plaintext
∏ emp-id, emp-name (
  σ e.city = c.company-city (
    (employee e ⨝ e.emp-id = w.emp-id works w)
    ⨝ w.company-name = c.company-name company c
  )
)
```

**ব্যাখ্যা**:
- **employee ⨝ works**: `employee` এবং `works` টেবিলগুলোকে `emp-id` ব্যবহার করে যোগ করা হচ্ছে, যাতে কর্মচারীর কাজের তথ্য পাওয়া যায়।
- **⨝ company**: এর পর, `company` টেবিলের সাথে যোগ করা হচ্ছে, যাতে কোম্পানির তথ্য পাওয়া যায়।
- **σ e.city = c.company-city**: সিলেক্ট করা হচ্ছে যেখানে কর্মচারীর শহর এবং কোম্পানির শহর এক।
- **∏ emp-id, emp-name**: কেবল `emp-id` এবং `emp-name` কলামগুলো প্রজেক্ট করা হচ্ছে।


