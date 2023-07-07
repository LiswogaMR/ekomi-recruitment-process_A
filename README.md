# ekomi-recruitment-process_A

The project is written in PHP and MySQL will need xampp running in your machine with Apache and MySQL active to be able to run the project and sql for database to configure

Extract or clone the project in your htdocs folder and inside the erd_sql_dumps folder there is a EKOMI EDR.pdf it just show how the database tables are connect and function as one unit there is also a CREATE DATABSE.docx file Copy the content of the file and run them in your mysql workbench or what ever environment you use to run MySQL

once everthing is set and running navigate to http://localhost:81/ekomi-recruitment-process_A/index.php this is the landing page 
You can change the port number according to how you set yours in the xampp or php.ini file In mine I default it to 81.

The database will be imported and ready to be used. 
It has One Admin user Email = Liswogar1@gmail.com and password is = '01'

The project is designed to add task and track the progress of the task as well as who is doing them and who has assigned te task as well as adding new users and adding new task. It got 2 views, The admin/HR and Employee views. 

As an Admin/HR you have the ability to add or edit or delete anything in the system including and you have the view to everything in the system.
When adding new user you select the permmission group they belong to either Admin, Hr or Employee, you enter the password for them and it get sent to them via email using the email template with their details, The user have the rights to change the password after then. You need to configure the email to work using your host port. 

As an Employee you have limited view, you can only view task assigned to you and only your user information, you cannot add or delete any user but only can edit your user information but not the permission set and manupulate your task as you will only see task assigned to you on the task tab, you can change the task status to either In Progree, On Hold, Active or Complete. 


I used The openweather API for displaying weather as it is free source and a little fast the only trick is the API key may expire. There are other reliable source to get this done this include googleweather API and many more. 

The project still need some touch-ups or improvement to make it a 100% okay such as sending an notification to the assignee person when the task get completed or status change or notifing the person who is assigned the task when a new task is added under their account or anything change in their task.

The reason why I used this workflow is for security reasons and proper workflow in the system. Not everyone should be able to see and do anything in the systems. There should be like a limit on things you do and see. As an employee it is not neccessary to add and edit people task without their consent and also as an employee you shouldn't see all the task being done as some may be private or doesn't require you to know of them.

Bootstrap provides a responsive grid system and pre-built CSS components that automatically adapt to different screen sizes and devices, ensuring a consistent and visually appealing user experience across devices.It offers a wide range of ready-to-use UI components, such as buttons, forms, navigation menus, and typography styles, which can significantly speed up development and reduce the need for custom CSS coding, allows customization through its robust theming capabilities, enabling developers to modify the look and feel of their web applications to match their brand or design requirements.

PHP is designed specifically for web development, providing features and functions tailored for building dynamic websites and web applications.
It also runs on various platforms, including Windows, macOS, Linux, and UNIX, making it highly portable. PHP also provide extensive support for interacting with databases, making it suitable for building database-driven web applications.

The combination of PHP as the programming language and Bootstrap HTML as the framework provides a solid foundation for building dynamic, database-driven web applications with a responsive and user-friendly interface. These technologies have a large user base, extensive documentation, and community support, making them reliable choices for web development projects.

After Logging in you should create many user with different permissions to have or see the difference in the flow of task and how the systems works.