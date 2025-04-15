# Library Information Managment System

This Library Information Management System is designed to manage library resources efficiently. It provides functionality which includes adding, removing, and updating information about books, users, and activities such as borrowing and returning of books. This can be applied in a real world library

## Modules and Interfaces

The following modules and interfaces are expected to be developed in the library management system.

### Login Module

* Interface:
	+ Username and Password fields.
	+ Dropdown to select user role (Admin/User) at the point of login.
	+ Login button.
* Features:
	+ Authentication using credentials.
	+ Redirection  to Admin dashboard or User dashboard based on role.

### Admin Dashboard

* Interfaces:
	+ Book Management:
		- Add Book: Form to input book details (e.g., title, author, ISBN, genre, quantity).
		- Update/Delete Book: Displaying books with options to edit or delete.
	+ User Management:
		- Add User: Form to register new users (name, email, role, etc.).
		- Update/Delete User: Displaying users with options to edit or delete.

### User Dashboard

* Interfaces:
	+ Search & Borrow Books:
		- Search bar with filters (e.g., title, author, genre).
		- List of available books with a "Borrow" button.
	+ Book Loan Management:
		- View borrowed books with due dates.
		- Return borrowed books.

### Book Loan and Return Module

* Features:
	+ Borrow: Reduce available quantity when a user borrows a book.
	+ Return: Increase available quantity and update the loan record.
	+ Restrictions: Limit the number of books a user can borrow.
