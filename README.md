# zoo_app
University project: Website for managing a zoo garden. The website is written in HTML, PHP, with a SQL database.

Task description:

The botanical garden conducts various tasks, primarily gardening but also various construction and finishing works. The garden has available computer equipment and aims to utilize it for implementing computer-assisted preparation and management of tasks. The garden is spread across several locations, each comprising several areas (sections). The tasks are always related to a single area.

Each task ("project") consists of assignments performed within a single day, though the entire task can naturally extend over a longer period. Tasks are executed sequentially within a project.

For each task, a manager prepares the staffing. Each assignment must be carried out by an employee with the appropriate specialization. An employee can handle only one task per day.

Every employee must have one or more specializations (all of which are documented in their personnel records). Multiple employees can share the same specialization.

The program should facilitate the following actions:

1. Adding new locations and areas.
2. Adding new employees and their specializations.
3. Introducing new tasks and assignments.
4. Establishing task assignments.
5. Modifying task completion deadlines (considering constraints).
6. Browsing the database.

There will be two user categories:

1. Manager, with full privileges.
2. Employee, with access restricted to information about tasks they are involved in.

# Usage
You can view the website here:
https://students.mimuw.edu.pl/~as420561/index.php?

Login information:
1. as an admin: Login: admin
                Password: 'karamba'
2. as an employee: Login: nr  ID (from 1 to 5)
                   Password: ogrod
