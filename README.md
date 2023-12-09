[![MIT License][license-shield]][license-url]
[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Issues][issues-shield]][issues-url]

[![Hits][hits-view]][hits-view-url]

# Daily Buddy API
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

Daily Buddy API is a native PHP RESTful API for Daily Buddy Mobile App.

## Getting Started

### Prerequisites

- PHP 7.2 or higher
- Composer installed
- MariaDB installed and running

### Installation

Copy code above to your terminal :

  ```
   $ composer require imdvlpr/dailybuddy-api
  ```

## Endpoints

The API endpoints are defined in the api folder. Below are the main endpoint :
   
   - **POST /dailybuddy/api/create-activity** : Create daily activity.
   
   - **POST /dailybuddy/api/delete-activity** : Delete current daily activity by id.
   
   - **POST /dailybuddy/api/edit-activity** : Edit current selected daily activity by id.

   - **POST /dailybuddy/api/get-activity-list** : get all activity list.

   - **POST /dailybuddy/api/update-activity-status** : Update daily activity status.

For more detailed information on each endpoint, refer to the API Documentation.

## Contributing

Contributions are welcome! Feel free to open issues or submit pull requests.

## License

This project is licensed under the MIT License.
Adjust the instructions and links based on your project structure and documentation location. If your API documentation is inside the `api` folder, provide a link to it accordingly.
