<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);
        // 头像假数据
        $avatars = [
            '/images/defineTopPic.jpg'
        ];
        // 生成数据集合
        $users = factory(User::class)
            ->times(10)
            ->make()
            ->each(function ($user, $index)
            use ($faker, $avatars) {
                // 从头像数组中随机取出一个并赋值
                $user->avatar = $faker->randomElement($avatars);
            });
        // 让隐藏字段可见，并将数据集合转换为数组
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();
        // 插入到数据库中
        User::insert($user_array);
        // 单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'Somewhere';
        $user->email = 'yoyomasky@gmail.com';
        $user->avatar = '/uploads/images/avatars/201909/25/1_1569393029_OaTy0BEyC7.jpg';
        $user->password = '$2y$10$A70jCP85H8PgKNu1.DTaaeP/vmMa/F1nPA/gyk/YqxCgqfco9uZXG';
        $user->introduction = 'I love you 3 thousand...';
        $user->save();
    }
}
