<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        return view('portfolio.index', [
            'profile'   => $this->profile(),
            'stats'     => $this->stats(),
            'education' => $this->education(),
            'experience' => $this->experience(),
            'skills'    => $this->skills(),
            'certifications' => $this->certifications(),
            'projects'  => $this->projects(),
            'contacts'  => $this->contacts(),
        ]);
    }

    private function profile(): array
    {
        return [
            'name'      => 'CRISZLE T. LAURETA',
            'role'      => 'Bachelor of Science in Information Technology Student',
            'tagline'   => 'A versatile student and with a strong interest in technology. Problem solving and continuous learning.',
            'location'  => 'Bangbangar, Bangued, Abra, Philippines',
            'bio'       => [
                'Magandang araw! I\'m Criszle T. Laureta, a graduating Bachelor of Science in Information Technology student with a passion for technology, creativity, and continuous learning.',
                'As I enter the final chapter of my college journey, I currently spend most of my time working on our Capstone project while balancing my responsibilities as a student and an intern. Through these experiences, I\'ve been able to grow not only as an IT student, but also as someone who enjoys turning ideas into something meaningful and useful.',
                'Beyond code and school, I\'m a dancer with years of experience, which has taught me discipline, confidence, and the importance of teamwork. I also enjoy watching series and movies, reading books, taking photos, editing, and exploring graphic design. These creative interests allow me to express myself in ways that are different from programming.',
            ],
            'avatar'    => asset('img/profile.svg'),
            'full_name' => 'CRISZLE T. LAURETA',
        ];
    }

    private function stats(): array
    {
        return [
            ['value' => '2+', 'label' => 'Years Learning & Building'],
            ['value' => '12+', 'label' => 'Projects Completed'],
            ['value' => '8+', 'label' => 'Certifications & Awards'],
        ];
    }

    private function education(): array
    {
        return [
            [
                'program'     => 'BS in Information Technology',
                'school'      => 'Data Center College of the Philippines - Bangued Campus',
                'type'        => 'Tertiary',
                'period'      => '2023 – Present',
                'detail'      => '',
                'highlights'  => [],
            ],
            [
                'program'     => 'General Academic Strand (GAS)',
                'school'      => 'Abra High School',
                'type'        => 'Secondary',
                'period'      => '2021 – 2023',
                'detail'      => '',
                'highlights'  => ['With Honors'],
            ],
        ];
    }

    private function experience(): array
    {
        return [
            [
                'role'     => 'Intern',
                'company'  => 'Social Security System',
                'period'   => 'August 2026 – Present',
                'detail'   => '',
                'highlights' => [],
            ],
            [
                'role'     => 'Student Aide',
                'company'  => 'Local Government Unit of Bangued',
                'period'   => '2020 – 2026',
                'detail'   => '',
                'highlights' => [
                    'Organized, filed, and maintained office records and documents.',
                    'Maintained professionalism, confidentiality, and accuracy in handling office records.',
                    'Collaborated with office staff to complete assigned tasks efficiently and meet deadlines.',
                ],
            ],
        ];
    }

    private function skills(): array
    {
        return [
            'categories' => [
                [
                    'title' => 'Programming Languages',
                    'icon'  => 'code',
                    'items' => [],
                ],
                [
                    'title' => 'Frameworks & Libraries',
                    'icon'  => 'layers',
                    'items' => [],
                ],
                [
                    'title' => 'Tools & Platforms',
                    'icon'  => 'wrench',
                    'items' => ['Git & GitHub', 'MySQL', 'VS Code', 'C#', 'VB.NET', 'Python', 'Java', 'SQL', 'PHP', 'CSS', 'HTML', 'Photoshop', 'Canva', 'CapCut'],
                ],
                [
                    'title' => 'Soft Skills',
                    'icon'  => 'users',
                    'items' => ['Problem Solving', 'Team Collaboration', 'Communication', 'Time Management', 'Adaptability'],
                ],
                [
                    'title' => 'Technical & Creative',
                    'icon'  => 'wrench',
                    'items' => ['Networking', 'Hardware & Software Troubleshooting', 'Prototyping', 'Graphic Designing', 'Video Editing'],
                ],
            ],
        ];
    }

    private function certifications(): array
    {
        return [
            [
                'title'  => 'Stay Alert, Stay Secure: Promoting Cyber Awareness',
                'issuer' => 'CHED',
                'date'   => 'July 23, 2026',
                'file'   => 'pdf_cert/Cyberawareness.pdf',
                'image'  => asset('pdf_cert/Cyberawareness.jpeg'),
            ],
            [
                'title'  => 'Computer Systems Servicing NCII',
                'issuer' => 'TESDA',
                'date'   => 'November 08, 2025',
                'file'   => 'pdf_cert/NC (1).pdf',
                'image'  => asset('pdf_cert/NC2.jpeg'),
            ],
            [
                'title'  => 'Online Safety Through Netiquette',
                'issuer' => 'DICT',
                'date'   => 'July 23, 2026',
                'file'   => 'pdf_cert/online safety.pdf',
                'image'  => asset('pdf_cert/netiquette.jpeg'),
            ],
            [
                'title'  => 'Data Analytics and Visualization Essentials',
                'issuer' => 'DICT',
                'date'   => 'December 11, 2025',
                'file'   => 'pdf_cert/data analytics.pdf',
                'image'  => asset('pdf_cert/VisualizationEssentials.jpeg'),
            ],
            [
                'title'  => 'Civil Service Eligibility (CSE) — Professional Level',
                'issuer' => 'Civil Service Commission (CSC)',
                'date'   => 'March 08, 2026',
                'file'   => '',
            ],
        ];
    }

    private function projects(): array
    {
        return [
            [
                'title'       => 'Holy Ghost School Online Information System',
                'description' => 'A web-based information system designed to provide organized access to essential school information at Holy Ghost School. The system includes interfaces for viewing academic details, announcements, and other school-related content.',
                'tech'        => ['Laravel', 'Tailwind CSS 3', 'MySQL'],
                'image'       => asset('img/Holy ghost.png?v=2'),
                'demo'        => '#',
                'repo'        => 'https://github.com/',
                'screenshots' => [
                    ['src' => asset('img/projects/portfolio.svg'), 'caption' => 'Home'],
                    ['src' => asset('img/projects/portfolio.svg'), 'caption' => 'About Section'],
                    ['src' => asset('img/projects/portfolio.svg'), 'caption' => 'Projects Grid'],
                    ['src' => asset('img/projects/portfolio.svg'), 'caption' => 'Skills'],
                    ['src' => asset('img/projects/portfolio.svg'), 'caption' => 'Contact'],
                    ['src' => asset('img/projects/portfolio.svg'), 'caption' => 'Footer'],
                ],
            ],
            [
                'title'       => 'QR Code Based Event Attendance System',
                'description' => 'An offline desktop-based attendance system designed to streamline event attendance tracking using QR codes. The system includes interfaces for managing student records, creating events, scanning QR codes, monitoring attendance, and generating attendance reports. It was developed to provide a faster and more organized way of recording attendance without requiring an internet connection.',
                'tech'        => ['VB.NET'],
                'image'       => asset('img/QRcode.png?v=2'),
                'demo'        => '#',
                'repo'        => 'https://github.com/',
                'screenshots' => [
                    ['src' => asset('img/projects/smart-home.svg'), 'caption' => 'Dashboard'],
                    ['src' => asset('img/projects/smart-home.svg'), 'caption' => 'Sensor Data'],
                    ['src' => asset('img/projects/smart-home.svg'), 'caption' => 'Device Controls'],
                    ['src' => asset('img/projects/smart-home.svg'), 'caption' => 'Charts View'],
                    ['src' => asset('img/projects/smart-home.svg'), 'caption' => 'Settings'],
                    ['src' => asset('img/projects/smart-home.svg'), 'caption' => 'Login'],
                ],
            ],
            [
                'title'       => 'Online Ordering and Reservation for Depresso',
                'description' => 'A web-based ordering and reservation system designed to streamline the services of Depresso Café. The system includes interfaces for browsing the menu, placing orders, making reservations, managing customer information, and monitoring orders and reservations. It was developed to provide customers with a convenient way to order products and reserve tables online.',
                'tech'        => ['VB.NET'],
                'image'       => asset('img/depresso.png'),
                'demo'        => '#',
                'repo'        => 'https://github.com/',
                'screenshots' => [
                    ['src' => asset('img/projects/events.svg'), 'caption' => 'Event List'],
                    ['src' => asset('img/projects/events.svg'), 'caption' => 'Registration'],
                    ['src' => asset('img/projects/events.svg'), 'caption' => 'Schedule'],
                    ['src' => asset('img/projects/events.svg'), 'caption' => 'Admin Panel'],
                    ['src' => asset('img/projects/events.svg'), 'caption' => 'Reports'],
                    ['src' => asset('img/projects/events.svg'), 'caption' => 'Login'],
                ],
            ],
            [
                'title'       => 'Inventory System for Verde Wood Furniture shop',
                'description' => 'A desktop-based inventory management system designed to organize and monitor the day-to-day inventory operations of Verde Wood. The system includes interfaces for managing furniture products, stock levels, suppliers, sales, and inventory reports, supported by a login screen and dashboard. It was developed to provide a more organized and efficient way of tracking furniture inventory and transactions.',
                'tech'        => ['VB.NET'],
                'image'       => asset('img/inventory.png'),
                'demo'        => '#',
                'repo'        => 'https://github.com/',
                'screenshots' => [
                    ['src' => asset('img/inventory.png'), 'caption' => 'Login'],
                    ['src' => asset('img/inventory.png'), 'caption' => 'Dashboard'],
                    ['src' => asset('img/inventory.png'), 'caption' => 'Products'],
                    ['src' => asset('img/inventory.png'), 'caption' => 'Reports'],
                ],
            ],
        ];
    }

    private function contacts(): array
    {
        return [
            'name'      => 'Criszle T. Laureta',
            'full_name' => 'Criszle T. Laureta',
            'email'     => 'criszlelaureta24@gmail.com',
            'phone'     => '+639536718063',
            'links'  => [
                ['label' => 'GitHub', 'icon' => 'github', 'url' => 'https://github.com/criszlelaureta'],
                ['label' => 'Facebook', 'icon' => 'facebook', 'url' => 'https://www.facebook.com/share/1Dgnv8B9or/'],
                ['label' => 'Instagram', 'icon' => 'instagram', 'url' => 'https://www.instagram.com/crisz_le'],
            ],
        ];
    }
}
