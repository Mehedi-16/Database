

### 🔹 i. **Find the titles of courses in the Comp. Sci. department that have 3 credits.**  
👉 Comp. Sci. ডিপার্টমেন্টে যেসব কোর্স ৩ ক্রেডিটের — ওগুলোর নাম বের করো।

```sql
SELECT title
FROM course
WHERE dept_name = 'Comp. Sci.' AND credits = 3;
```

---

### 🔹 ii. **Find the IDs of all students who were taught by an instructor named Einstein (no duplicates).**  
👉 Einstein নামের শিক্ষক যাদের ক্লাস নিয়েছেন, সেইসব students-এর ID (repeat ছাড়া) দাও।

```sql
SELECT DISTINCT takes.s_ID
FROM takes
JOIN teaches USING (course_id, sec_id, semester, year)
JOIN instructor ON teaches.i_ID = instructor.i_ID
WHERE instructor.i_name = 'Einstein';
```

---

### 🔹 iii. **Find the ID and name of each student who has taken at least one Comp. Sci. course (no duplicates).**  
👉 যারা কমপক্ষে একটা Comp. Sci. কোর্স নিয়েছে — তাদের ID আর নাম দাও (repeat ছাড়া)।

```sql
SELECT DISTINCT student.s_ID, student.s_name
FROM student
JOIN takes ON student.s_ID = takes.s_ID
JOIN course ON takes.course_id = course.course_id
WHERE course.dept_name = 'Comp. Sci.';
```

---

### 🔹 iv. **Find the course ID, section ID, and building for each section of a Biology course.**  
👉 Biology ডিপার্টমেন্টের প্রতিটি কোর্সের section অনুযায়ী course_id, section no আর building বের করো।

```sql
SELECT section.course_id, section.sec_id, section.building
FROM section
JOIN course ON section.course_id = course.course_id
WHERE course.dept_name = 'Biology';
```

---

### 🔹 v. **Output instructor names sorted by the ratio of their salary to their department's budget (ascending order).**  
👉 Instructor-দের নাম দাও, যাদের salary/budget অনুপাতে ছোট থেকে বড়ভাবে সাজানো হয়েছে।

```sql
SELECT instructor.i_name, (instructor.salary / department.budget) AS ratio
FROM instructor
JOIN department ON instructor.dept_name = department.dept_name
ORDER BY ratio ASC;
```

---

সবগুলো প্রশ্ন এক জায়গায় English সহ করে দিলাম যেন তুমি সহজে কপি-পেস্ট করে বুঝিয়ে দিতে পারো বা সাবমিট করতে পারো ✨  
আর যদি চাও আমি এগুলোর একটা সাজানো Readme-style ফাইল বানিয়ে দিই, সেটাও বলে দাও — করে দিচ্ছি 😊
