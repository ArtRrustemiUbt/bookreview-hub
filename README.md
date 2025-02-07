# BookReview Hub - Project Documentation

## Project Overview

**BookReview Hub** is a dynamic web platform designed for book enthusiasts to discover, review, and rate books. It provides users with an interactive experience where they can browse books, leave reviews, and engage with other readers. Administrators can manage books, authors, genres, and user reviews efficiently.

## Key Features

- **User Authentication**: Secure login and registration functionality.
- **Book Management**: Add, edit, delete, and duplicate books with cover images.
- **Author Management**: Manage author profiles, including bios, photos, and social links.
- **Genre Management**: Categorize books based on genres.
- **Review System**: Users can rate books with stars and leave comments. Average ratings are displayed on book pages.
- **Search & Filtering**: Search for books by title and filter them by authors or genres.
- **Pagination**: Efficient loading and navigation through books with pagination.
- **Responsive Design**: Fully responsive layout for optimal viewing on all devices.

## Technologies Used

### Backend

- **Laravel**: A robust PHP framework used for building the RESTful API and handling backend logic.
- **Spatie Laravel Media Library**: For managing and storing media files such as book covers and author photos.
- **Inertia.js**: Connects Laravel with Vue.js for seamless single-page application functionality.
- **MySQL**: Relational database for storing all application data.

### Frontend

- **Vue.js 3**: Progressive JavaScript framework for building interactive user interfaces.
- **Tailwind CSS**: Utility-first CSS framework for designing responsive and modern UI.
- **Inertia.js**: Bridges the gap between server-side frameworks and client-side frameworks, providing a seamless SPA experience without the complexity of a traditional SPA.

### Deployment & DevOps

- **Docker**: Containerized environment for consistent development and deployment.

## Project Structure

- **Controllers**: Handle business logic and data retrieval.

  - `BookController`: Manages CRUD operations for books.
  - `AuthorController`: Manages CRUD operations for authors.
  - `GenreController`: Manages genres.
  - `ReviewController`: Handles review submissions and validations.

- **Models**: Represent database entities and relationships.

  - `Book`, `Author`, `Genre`, `Review`

- **Views (Vue Components)**:

  - `Books/Index.vue`: Lists all books with pagination.
  - `Books/Show.vue`: Displays single book details and reviews.
  - `Authors/Show.vue`: Displays author profiles and their books.
  - `Reviews/Create.vue`: Review submission form.

- **Routes**: Defined in `web.php`, handling API endpoints and page rendering.

  - `Route::resource('books', BookController::class)`
  - `Route::resource('authors', AuthorController::class)`
  - `Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');`

## User Roles

- **Admin**: Full access to manage books, authors, genres, and reviews.
- **Authenticated Users**: Can leave reviews, rate books, and manage their profile.
- **Guests**: Can browse books and view reviews but must register to interact.

## Future Enhancements

- **User Profile Pages**: Allow users to see their own reviews and book lists.
- **Advanced Filtering**: Filter by rating, publication date, and more.
- **Notifications**: Alert users about new reviews on books they’ve reviewed.
- **Wishlist & Favorites**: Users can mark books to read later.

## Conclusion

BookReview Hub is a feature-rich platform that combines powerful backend technologies with an intuitive frontend to create an engaging book discovery and review experience. With scalable architecture and clean design, it’s built to grow with its user base and continuously evolve with new features.

