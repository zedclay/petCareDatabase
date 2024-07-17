
# PetCare Database


### Steps
1. Clone the repository
   \`\`\`sh
   git clone https://github.com/zedclay/petCareDatabase.git
   \`\`\`
2. Navigate to the project directory
   \`\`\`sh
   cd petCareDatabase
   \`\`\`
3. Install dependencies
   \`\`\`sh
   composer install
   \`\`\`
4. Copy the example environment file and set up your environment variables
   \`\`\`sh
   cp .env.example .env
   \`\`\`
5. Generate an application key
   \`\`\`sh
   php artisan key:generate
   \`\`\`
6. Run the database migrations
   \`\`\`sh
   php artisan migrate
   \`\`\`
7. Serve the application
   \`\`\`sh
   php artisan serve
   \`\`\`
