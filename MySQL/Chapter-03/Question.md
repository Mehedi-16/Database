
# University Database Schema 

```
student(s_ID, s_name, dept_name)

instructor(i_ID, i_name, dept_name, salary)

course(course_id, title, dept_name, credits)

takes(s_ID, course_id, sec_id, semester, year, grade)

teaches(i_ID, course_id, sec_id, semester, year)

section(course_id, sec_id, semester, year, building, room_number, time_slot_id)

department(dept_name, building, budget)
```

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
ভাবো: instructor + teaches + takes — এই তিনটা জোড়া দিয়ে দেখতে হবে কে কাকে ক্লাস নিয়েছে।
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

**********************************************************************************************************************************************************************************************
---

```markdown
# University Schema SQL Operations

This repository contains SQL statements to perform operations using the **University Schema**. The tasks involve inserting, deleting, and modifying data for courses, sections, and enrollments.

## Operations

### a. Create a New Course
Add a course `CS-001` titled **"Weekly Seminar"** with 0 credits under the `Comp. Sci.` department.

```sql
INSERT INTO course (course_id, title, dept_name, credits)
VALUES ('CS-001', 'Weekly Seminar', 'Comp. Sci.', 0);
```

---

### b. Create a Section
Add a section of course `CS-001` in **Fall 2017**, with `sec_id = 1`. The location is not yet specified.

```sql
INSERT INTO section (course_id, sec_id, semester, year, building, room_number, time_slot_id)
VALUES ('CS-001', '1', 'Fall', 2017, NULL, NULL, NULL);
```

---

### c. Enroll Students
Enroll all students in the `Comp. Sci.` department into this new section.

```sql
INSERT INTO takes (ID, course_id, sec_id, semester, year, grade)
SELECT ID, 'CS-001', '1', 'Fall', 2017, NULL
FROM student
WHERE dept_name = 'Comp. Sci.';
```

---

### d. Delete Enrollment for a Specific Student
Remove the student with ID `12345` from the above section.

```sql
DELETE FROM takes
WHERE ID = 12345 AND course_id = 'CS-001' AND sec_id = '1'
      AND semester = 'Fall' AND year = 2017;
```

---

### e. Delete the Course
Remove course `CS-001`. ⚠️ **Important:** You must delete all related sections before deleting the course to maintain referential integrity.

```sql
-- Step 1: Delete related sections
DELETE FROM section
WHERE course_id = 'CS-001';

-- Step 2: Delete the course
DELETE FROM course
WHERE course_id = 'CS-001';
```

---

### f. Delete Takes Records for Courses Containing "Advanced"
Remove all `takes` records for courses that contain the word "advanced" (case-insensitive) in the title.

```sql
DELETE FROM takes
WHERE course_id IN (
    SELECT course_id FROM course
    WHERE LOWER(title) LIKE '%advanced%'
);
```

---

## Schema Assumptions

- Tables used: `course`, `section`, `student`, `takes`
- Common fields:
  - `course_id`, `sec_id`, `semester`, `year`, `ID`, `dept_name`, `title`, `credits`, etc.

---

## License
This project is open source and available under the [MIT License](LICENSE).

```

Let me know if you want to include schema diagrams or ER diagrams too!
