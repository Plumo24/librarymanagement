# Library Information Managment System

This Library Information Management System is designed to manage library resources efficiently. It provides functionality for adding, removing, and updating information about books, users, and activities such as borrowing and returning of books.

## Modules and Interfaces

The following modules and interfaces are expected to be developed in this system.

### Login Module

* Interface:
	+ Username and Password fields.
	+ Dropdown to select user role (Admin/User).
	+ Login button.
* Features:
	+ Authentication using credentials.
	+ Redirect to admin dashboard or user dashboard based on role.

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
	+ Loan Management:
		- View borrowed books with due dates.
		- Return borrowed books.

### Book Loan and Return Module

* Features:
	+ Borrow: Reduce available quantity when a user borrows a book.
	+ Return: Increase available quantity and update the loan record.
	+ Restrictions: Limit the number of books a user can borrow.
