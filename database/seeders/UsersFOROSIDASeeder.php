<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersFOROSIDASeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $socioImplementador = 'G.CO8.AFNV.1';

        $users = [
            [
                'username' => 'G.C05.AFNV.20',
                'password' => 'a7f9k2m1zq',
            ],
            [
                'username' => 'G.C05.AFNV.19',
                'password' => 'p4x8b2n7wq',
            ],
            [
                'username' => 'G.C05.AFNV.13',
                'password' => 'd3l6v9t2sa',
            ],
            [
                'username' => 'G.C05.AFNV.14',
                'password' => 'm8q2r5z7xc',
            ],
            [
                'username' => 'G.C05.AFNV.15',
                'password' => 's1w9e3k6vb',
            ],
            [
                'username' => 'G.C05.AFNV.17',
                'password' => 'z6n4y8p2tr',
            ],
            [
                'username' => 'G.C05.AFNV.16',
                'password' => 'b7v3c1x9lm',
            ],
            [
                'username' => 'G.C06.AFNV.22',
                'password' => 'q2w8e4r6ty',
            ],
            [
                'username' => 'G.C06.AFNV.27',
                'password' => 'u1i9o3p5lk',
            ],
            [
                'username' => 'G.C06.AFNV.21',
                'password' => 'j8h2g4f6ds',
            ],
            [
                'username' => 'G.C06.AFNV.23',
                'password' => 'a9s7d5f3gh',
            ],
            [
                'username' => 'G.C06.AFNV.29',
                'password' => 'z2x4c6v8bn',
            ],
            [
                'username' => 'G.C06.AFNV.24',
                'password' => 'm1n3b5v7cx',
            ],
            [
                'username' => 'G.C06.AFNV.26',
                'password' => 'l4k6j8h2gf',
            ],
            [
                'username' => 'G.C06.AFNV.25',
                'password' => 'd5s7a9q1we',
            ],
            [
                'username' => 'G.C06.AFNV.28',
                'password' => 'r3t5y7u9io',
            ],
            [
                'username' => 'G.C07.AFNV.31',
                'password' => 'p6o8i2u4yt',
            ],
            [
                'username' => 'G.C07.AFNV.32',
                'password' => 'e1r3t5y7ui',
            ],
            [
                'username' => 'G.C07.AFNV.33',
                'password' => 'w9q7a5s3df',
            ],
            [
                'username' => 'G.C07.AFNV.37',
                'password' => 'c2v4b6n8ml',
            ],
            [
                'username' => 'G.C07.AFNV.34',
                'password' => 'k1j3h5g7fd',
            ],
            [
                'username' => 'G.C07.AFNV.36',
                'password' => 's8d6f4g2hj',
            ],
            [
                'username' => 'G.C07.AFNV.35',
                'password' => 'l9k7j5h3gf',
            ],
            [
                'username' => 'G.C07.AFNV.38',
                'password' => 'b2n4m6v8cx',
            ],
            [
                'username' => 'G.C07.AFNV.30',
                'password' => 'q1w3e5r7ty',
            ],
            [
                'username' => 'G.CO8.AFNV.1',
                'password' => 'u8i6o4p2lk',
            ],
            [
                'username' => 'G.CO8.AFNV.2',
                'password' => 'j7h5g3f1ds',
            ],
            [
                'username' => 'G.CO8.AFNV.3',
                'password' => 'a6s4d2f8gh',
            ],
            [
                'username' => 'G.CO8.AFNV.4',
                'password' => 'z5x3c1v7bn',
            ],
            [
                'username' => 'G.CO8.AFNV.5',
                'password' => 'm4n2b8v6cx',
            ],
            [
                'username' => 'G.CO8.AFNV.6',
                'password' => 'l3k1j7h5gf',
            ],
            [
                'username' => 'G.CO8.AFNV.7',
                'password' => 'd2s8a6q4we',
            ],
            [
                'username' => 'G.CO8.AFNV.8',
                'password' => 'r1t7y5u3io',
            ],
            [
                'username' => 'G.CO8.AFNV.9',
                'password' => 'p9o7i5u3yt',
            ],
            [
                'username' => 'G.CO8.AFNV.10',
                'password' => 'e8r6t4y2ui',
            ],
            [
                'username' => 'G.CO8.AFNV.11',
                'password' => 'w7q5a3s1df',
            ],
            [
                'username' => 'G.CO8.AFNV.12',
                'password' => 'c6v4b2n8ml',
            ],
            [
                'username' => 'C.AFNV',
                'password' => 'k5j3h1g7fd',
            ],
            [
                'username' => 'R3.AFNV',
                'password' => 's4d2f8g6hj',
            ],
            [
                'username' => 'ME.AFNV',
                'password' => 'l1k7j5h3gf',
            ],
        ];

        foreach ($users as $userData) {
            \App\Models\User::where('username', $userData['username'])
                ->update(['password' => bcrypt($userData['password'])]);
        }
    }
}
