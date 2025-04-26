
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

নিচে দেওয়া SQL কোডগুলো সহজ এবং সরল ভাষায় লিখলাম, যাতে আপনি সহজে বুঝতে পারেন:

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
