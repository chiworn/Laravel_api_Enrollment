<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Course;
use App\Models\Timeslot;
use App\Models\Termslot;
use App\Models\Price;
use App\Models\Enrollment;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // 1. Seed Students (20 random students)
        for ($i = 0; $i < 20; $i++) {
            Student::create([
                'frist_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'email_stu'  => $faker->unique()->safeEmail,
                'phone_num'  => $faker->phoneNumber,
                'gender'     => $faker->randomElement(['Male', 'Female', 'Other']),
                'creat_at'   => now()
            ]);
        }

        // 2. Seed Courses (Pre-defined list)
        $courses = ['Web Development Bootcamp', 'Mobile App Development', 'UI/UX Masterclass', 'Data Science & AI', 'Python for Beginners'];
        foreach ($courses as $course) {
            Course::create([
                'course_name'    => $course,
                'description'    => $faker->sentence(12),
                'duration_month' => $faker->numberBetween(1, 6),
                'created_at'     => now()
            ]);
        }

        // 3. Seed Timeslots
        $times = ['08:00 AM - 10:00 AM', '10:30 AM - 12:30 PM', '01:00 PM - 03:00 PM', '05:00 PM - 07:00 PM'];
        foreach ($times as $time) {
            $parts = explode(' - ', $time);
            Timeslot::create([
                'start_time' => $parts[0],
                'end_time'   => $parts[1],
                'created_at' => now()
            ]);
        }

        // 4. Seed Termslots (Days)
        $days = ['Monday - Wednesday', 'Tuesday - Thursday', 'Weekend', 'Everyday Intensive'];
        foreach ($days as $day) {
            Termslot::create([
                'tern_day'   => $day,
                'created_at' => now()
            ]);
        }

        // 5. Seed Prices
        $prices = [150.00, 250.00, 300.00, 500.00, 99.99];
        foreach ($prices as $price) {
            Price::create([
                'price_course' => $price,
                'created_at'   => now()
            ]);
        }

        // 6. Seed Enrollments (30 realistic random enrollments connecting keys)
        // Fetch arrays of IDs generated from the steps above
        $courseIds = Course::pluck('id')->toArray();
        $timeslotIds = Timeslot::pluck('id')->toArray();
        $termslotIds = Termslot::pluck('id')->toArray();
        $priceIds = Price::pluck('id')->toArray();

        for ($i = 0; $i < 30; $i++) {
            Enrollment::create([
                'course_id'   => $faker->randomElement($courseIds),
                'timeslot_id' => $faker->randomElement($timeslotIds),
                'term_id'     => $faker->randomElement($termslotIds),
                'price_id'    => $faker->randomElement($priceIds),
                'Frist_name'  => $faker->firstName,
                'last_name'   => $faker->lastName,
                'phone'       => $faker->phoneNumber,
                'email'       => $faker->safeEmail,
                'status'      => $faker->randomElement(['Active', 'Pending', 'Completed', 'Dropped']),
            ]);
        }
    }
}
