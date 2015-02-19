<snippet>
  <content>
# ${1:CIT 3rd Year Project OMS}

Project Name: Online Free Choice Module System

## Usage

To allow CIT students to easily and seemly navigate through all of the available free choice modules for that particular semester and enroll in them if they meet the necessary criteria

## Team Members

- Ricardo Varanda
- Ronan Sammon
- Robert Serwin
- Rober Damery

## History

- [x] Login Complete (18th Feb 2015)
- [x] Filtering System (19th Feb 2015)
- [ ] Feel Free to add more items...

## Layout System

I have created a layout system as follows:
P.S its all sudo code.
'''
	This code runs when a user accesses our website:

	if(userIsLoggedIn) {
		if(userIsStudent){
        	Student.layout
        } elseif(userIsLecturer) {
        	Lecturer.layout
        } elseif(userIsHOD) {
        	Hod.layout
        } elseif(userIsTech){
            Technician.layout
        }
    } else {
    	sendToLoginPage
    }

    it checks if the user is checked in and sends them to whatever page depending on their status.


A live version of this script can be seen here:
[Login Script](https://github.com/RicardoVaranda/Module-System/blob/master/app/controllers/HomeController.php#L5)

We are going to need to create different layouts for the following:
- Change password (kind of done)
- Change secret question
- Module boxes (done)
- Profile -> each user needs to have different stuff on theirs
- Lecturer modules teaching template
- Management pages
	- HOD manage:
		- electives
		- lecturers
		- modules
	- TECH manage:
		- Deps
		- faculty
		- users [maybe a db view]
- Manage timetables page


The reason for this is so we can have a robust system that we can simply
use plugin templates to do things we require it. It will also help
with conflicts as we will not be working in the same files. I 
recommend you take a look at this folder:
[Views Folder](https://github.com/RicardoVaranda/Module-System/blob/master/views/)

This is where all of the html work is done, There are various files in there and
they pretty much explain what templates they have inside them for example,
the account file has templates for changing a users password and signing in.
If needed create a new file within the views folder and contact me and I will
explain to you all about how routes work and how you can link them.


## TO DO

- We need to start creating milestones and issues on github
- We need to keep track of all the issues and stop them as we complete them
- We need to start documenting steps as we go along
- If you can take some screen shots of the development it might help increase some pages


**Brain can't think any longer will update further if required.**

</content>
</snippet>
