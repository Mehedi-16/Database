# University Database Schema 

```
classroom(building, room number, capacity)
department(dept name, building, budget)
course(course id, title, dept name, credits)
instructor(ID, name, dept name, salary)
section(course id, sec id, semester, year, building, room number, time slot id)
teaches(ID, course id, sec id, semester, year)
student(ID, name, dept name, tot cred)
takes(ID, course id, sec id, semester, year, grade)
advisor(s ID, i ID)
time slot(time slot id, day, start time, end time)
prereq(course id, prereq id)

```

### ✅ 1. **Find the titles of courses in the Comp. Sci. department that have 3 credits**

```sql
SELECT title
FROM course
WHERE dept_name = 'Comp. Sci.' AND credits = 3;
```

---

### ✅ 2. **Find the IDs of all students who were taught by an instructor named Einstein; make sure there are no duplicates in the result.**

```sql
SELECT DISTINCT teaches.ID
FROM teaches,instructor
WHERE teaches.ID = instructor.ID
AND instructor.name = 'Einstein';
```
---

### ✅ 3. **Find the highest salary of any instructor**

```sql
SELECT MAX(salary) AS highest_salary
FROM instructor;
```

---

### ✅ 4. **Find all instructors with the highest salary**

```sql
SELECT name, salary
FROM instructor
WHERE salary = (SELECT MAX(salary) 
                FROM instructor);
```

---

### ✅ 5. **Find enrollment of each section in Fall 2017**

```sql
SELECT course_id, sec_id, semester, year, COUNT(ID) AS enrollment
FROM takes
WHERE semester = 'Fall' AND year = 2017
GROUP BY course_id, sec_id, semester, year;
```

---

### ✅ 6. **Find maximum enrollment in Fall 2017**

👉 *Fall 20017 এ কোন সেকশনে সবচেয়ে বেশি ভর্তি হয়েছিল, তার সংখ্যা বের করো।*

```sql

SELECT MAX(enrollment)
FROM (
  SELECT COUNT(ID) AS enrollment
  FROM takes
  WHERE semester = 'Autumn' AND year = 2009
  GROUP BY course_id, sec_id
) AS temp;
```

---

### ✅ 7. **Find sections that had maximum enrollment in Autumn 2009**

👉 *যেসব সেকশনে সবচেয়ে বেশি ভর্তি হয়েছিল, সেগুলো খুঁজে বের করো।*

```sql
SELECT course_id, sec_id
FROM takes
WHERE semester = 'Autumn' AND year = 2009
GROUP BY course_id, sec_id
HAVING COUNT(ID) = (
  SELECT MAX(enrollment)
  FROM (
    SELECT COUNT(ID) AS enrollment
    FROM takes
    WHERE semester = 'Autumn' AND year = 2009
    GROUP BY course_id, sec_id
  ) AS temp
);
```

---

### ✅ 8. **Find the total number of (distinct) students who have taken course sections taught by instructor ID 110011**

```sql
SELECT COUNT(DISTINCT takes.ID) AS total_students
FROM teaches, takes
WHERE teaches.course_id = takes.course_id
  AND teaches.sec_id = takes.sec_id
  AND teaches.semester = takes.semester
  AND teaches.year = takes.year
  AND teaches.ID = 110011;

```

---

### ✅ 9. **Insert students with more than 100 credits into instructor table**

👉 *যেসব ছাত্রের ক্রেডিট ১০০ এর বেশি, তাদের instructor টেবিলে insert করো, বেতন হবে 10000।*

```sql

INSERT INTO instructor (ID, name, dept_name, salary)
SELECT ID, name, dept_name, 10000
FROM student
WHERE tot_cred > 100;

```

---

### ✅ 10. **Display a list of all instructors, showing their ID, name, and the number of sections that they have taught. Make sure to show the number of sections as 0 for instructors who have not taught any section. Your query should use an outerjoin, and should not use scalar subqueries.**

👉 *প্রতিটি instructor কতটি section পড়িয়েছেন, সেটি দেখাও। যাঁরা কিছুই পড়াননি, তাদের 0 দেখাও।*

```sql
SELECT instructor.ID, instructor.name, COUNT(teaches.course_id) AS section_count
FROM instructor
LEFT JOIN teaches ON instructor.ID = teaches.ID
GROUP BY instructor.ID, instructor.name;
```

# Another....

### 🔹 **a. Question:**

**Find the IDs of all students (in descending order) who were taught by an instructor named 'EINSTIN'. Make sure there are no duplicate student IDs in the result.**

✅ **Answer:**

```sql
SELECT DISTINCT teaches.ID
FROM teaches, instructor
WHERE teaches.ID = instructor.ID
AND instructor.name = 'Einstein'
ORDER BY teaches.ID DESC;

```

---

### 🔹 **b. Question:**

**Find the ID and name of each student (ascending order) who has taken at least one Comp. Sci. course. Make sure there are no duplicate names in the result.**

✅ **Answer:**

```sql
SELECT DISTINCT student.ID, student.name
FROM student,takes,course
WHERE student.ID = takes.ID
AND takes.course_id = course.course_id
 AND course.dept_name = 'Comp. Sci.'
ORDER BY student.ID ASC;

```

---

### 🔹 **c. Question:**

**Output instructor names sorted by the ratio of their salary to their department's budget in descending order.**

✅ **Answer:**

```sql
SELECT instructor.name, (instructor.salary / department.budget) AS ratio
FROM instructor, department
WHERE instructor.dept_name = department.dept_name
ORDER BY ratio DESC;
```

---

### 🔹 **d. Question:**

**Output instructor names and buildings for each building where an instructor has taught.
Include instructor names who haven’t taught any classes (building should be NULL).**

✅ **Answer:**

```sql
SELECT instructor.name, section.building
FROM instructor
LEFT JOIN teaches ON instructor.ID = teaches.ID
LEFT JOIN section ON teaches.course_id = section.course_id 
                 AND teaches.sec_id = section.sec_id 
                 AND teaches.semester = section.semester 
                 AND teaches.year = section.year;
```

---



# MID Tearm............................

```
classroom(building, room number, capacity)
department(dept name, building, budget)
course(course id, title, dept name, credits)
instructor(ID, name, dept name, salary)
section(course id, sec id, semester, year, building, room number, time slot id)
teaches(ID, course id, sec id, semester, year)
student(ID, name, dept name, tot cred)
takes(ID, course id, sec id, semester, year, grade)
advisor(s ID, i ID)
time slot(time slot id, day, start time, end time)
prereq(course id, prereq id)

```


### 🔹 **i. Find the titles of courses in the Comp. Sci. department that have 3 credits.**  
**উত্তর:** কমপক্ষে ৩ ক্রেডিটের কম্পিউটার সায়েন্সের কোর্সের নাম বের করতে:

```sql
SELECT title
FROM course
WHERE dept_name = 'Comp. Sci.' AND credits = 3;
```

---

### 🔹 **ii. Find the IDs of all students who were taught by an instructor named Einstein (no duplicates).**  
**উত্তর:** Einstein নামের শিক্ষক যাদের ক্লাস নিয়েছেন, সেইসব ছাত্রদের ID বের করতে:

```sql
SELECT DISTINCT takes.ID
FROM takes
JOIN teaches ON takes.course_id = teaches.course_id AND takes.sec_id = teaches.sec_id
JOIN instructor ON teaches.ID = instructor.ID
WHERE instructor.name = 'Einstein';
```

---

### 🔹 **iii. Find the ID and name of each student who has taken at least one Comp. Sci. course (no duplicates).**  
**উত্তর:** যেসব ছাত্র কমপক্ষে একটানা কম্পিউটার সায়েন্সের কোর্স নিয়েছে তাদের ID এবং নাম বের করতে:

```sql
SELECT DISTINCT student.ID, student.name
FROM student
JOIN takes ON student.ID = takes.ID
JOIN course ON takes.course_id = course.course_id
WHERE course.dept_name = 'Comp. Sci.';
```

---

### 🔹 **iv. Find the course ID, section ID, and building for each section of a Biology course.**  
**উত্তর:** Biology কোর্সের প্রতিটি সেকশনের course ID, section ID, এবং building বের করতে:

```sql
SELECT section.course_id, section.sec_id, section.building
FROM section
JOIN course ON section.course_id = course.course_id
WHERE course.dept_name = 'Biology';
```

---

### 🔹 **v. Output instructor names sorted by the ratio of their salary to their department's budget (ascending order).**  
**উত্তর:** শিক্ষকদের নাম দিন, যাদের salary/budget অনুপাত অনুযায়ী সাজানো হয়েছে ছোট থেকে বড়:

```sql
SELECT instructor.name, (instructor.salary / department.budget) AS ratio
FROM instructor
JOIN department ON instructor.dept_name = department.dept_name
ORDER BY ratio ASC;
```

---

### **SQL Operations**

#### a. **Create a New Course**
কম্পিউটার সায়েন্স ডিপার্টমেন্টে নতুন কোর্স `CS-001` (Weekly Seminar) ০ ক্রেডিটের হিসেবে তৈরি করতে:

```sql
INSERT INTO course (course_id, title, dept_name, credits)
VALUES ('CS-001', 'Weekly Seminar', 'Comp. Sci.', 0);
```

---

#### b. **Create a Section**
`CS-001` কোর্সের একটি সেকশন তৈরি করতে:

```sql
INSERT INTO section (course_id, sec_id, semester, year, building, room_number, time_slot_id)
VALUES ('CS-001', '1', 'Fall', 2017, NULL, NULL, NULL);
```

---

#### c. **Enroll Students**
কম্পিউটার সায়েন্স ডিপার্টমেন্টের সব স্টুডেন্টকে `CS-001` কোর্সের সেকশনে নাম লেখানোর জন্য:

```sql
INSERT INTO takes (ID, course_id, sec_id, semester, year, grade)
SELECT ID, 'CS-001', '1', 'Fall', 2017, NULL
FROM student
WHERE dept_name = 'Comp. Sci.';
```

---

#### d. **Delete Enrollment for a Specific Student**
`12345` ID এর স্টুডেন্টকে `CS-001` কোর্সের সেকশন থেকে মুছে ফেলার জন্য:

```sql
DELETE FROM takes
WHERE ID = 12345 AND course_id = 'CS-001' AND sec_id = '1'
      AND semester = 'Fall' AND year = 2017;
```

---

#### e. **Delete the Course**
কোর্স `CS-001` মুছে ফেলার জন্য প্রথমে সম্পর্কিত সেকশনগুলো মুছে তারপর কোর্সটি মুছতে হবে:

```sql
-- Step 1: Delete related sections
DELETE FROM section
WHERE course_id = 'CS-001';

-- Step 2: Delete the course
DELETE FROM course
WHERE course_id = 'CS-001';
```

---

#### f. **Delete Takes Records for Courses Containing "Advanced"**
যেসব কোর্সের নামের মধ্যে "Advanced" শব্দ আছে, তাদের `takes` রেকর্ড মুছে ফেলার জন্য:

```sql
DELETE FROM takes
WHERE course_id IN (
    SELECT course_id FROM course
    WHERE LOWER(title) LIKE '%advanced%'
);
```

---

এই SQL কোডগুলো আপনার কাজের জন্য সহজ এবং সরল উপায়ে তৈরি করা হয়েছে। 😊
