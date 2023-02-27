<?php

namespace Database\Seeders;

use Modules\Livestream\Models\OldAnalytics;
use Illuminate\Database\Seeder;

class OldAnalyticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $att = [
            [
                'name' => 'Introduction to the Book of Philippians Part 2.pdf',
                'count' => 95,
            ],
            [
                'name' => 'Introduction to the Book of Philippians Part 2.pptx',
                'count' => 2875,
            ],
            [
                'name' => 'Christian Conflict Resolution - Rules of Engagement.pptx',
                'count' => 150,
            ],
            [
                'name' => 'Christian Conflict Resolution - Rules of Engagement.pdf',
                'count' => 134,
            ],
            [
                'name' => 'Introduction to Philippians - The Philippian Church Plant Part 1.pdf',
                'count' => 94,
            ],
            [
                'name' => 'Introduction to Philippians - The Philippian Church Plant Part 1.pptx',
                'count' => 167,
            ],
            [
                'name' => 'Philippians 1  1-11 Life Principle 1 See Others The Way Christ Sees Them.pdf',
                'count' => 69,
            ],
            [
                'name' => 'Philippians 1  1-11 Life Principle 1 See Others The Way Christ Sees Them.pptx',
                'count' => 105,
            ],
            [
                'name' => 'Philippians 1  12-18 Life Principle 2 Using Life’s Circumstances To Advance The Cause of Christ.pptx',
                'count' => 55,
            ],
            [
                'name' => 'Philippians 1  12-18 Life Principle 2 Using Life’s Circumstances To Advance The Cause of Christ.pdf',
                'count' => 52,
            ],
            [
                'name' => 'Philippians 1  19-26 - Life Principle 3 Living Out the God Given Purpose For Your Life.pdf',
                'count' => 63,
            ],
            [
                'name' => 'Philippians 1  19-26 - Life Principle 3 Living Out the God Given Purpose For Your Life.pptx',
                'count' => 99,
            ],
            [
                'name' => 'Philippians 1  27-2 11 Life Principle 4 Maintaining the Unity of the Faith Part 1.pdf',
                'count' => 61,
            ],
            [
                'name' => 'Philippians 1  27-2 11 Life Principle 4 Maintaining the Unity of the Faith Part 1.pptx',
                'count' => 68,
            ],
            [
                'name' => 'Philippians 1  27-2 11 Life Principle 4 Maintaining the Unity of the Faith Part 2.pdf',
                'count' => 70,
            ],
            [
                'name' => 'Philippians 1  27-2 11 Life Principle 4 Maintaining the Unity of the Faith Part 2.pptx',
                'count' => 322,
            ],
            [
                'name' => 'Philippians 1  27-2 11 Life Principle 4 Maintaining the Unity of the Faith Part 3.pdf',
                'count' => 71,
            ],
            [
                'name' => 'Philippians 1  27-2 11 Life Principle 4 Maintaining the Unity of the Faith Part 3.pptx',
                'count' => 169,
            ],
            [
                'name' => 'Philippians 2  12-18 Life Principle 5 Working out your salvation as God works salvation in you.pdf',
                'count' => 54,
            ],
            [
                'name' => 'Philippians 2  12-18 Life Principle 5 Working out your salvation as God works salvation in you.pptx',
                'count' => 75,
            ],
            [
                'name' => 'Philippians 2  19-30 Life Principle 6  Surrounding Yourself With A Mature Christian Support Group.pdf',
                'count' => 58,
            ],
            [
                'name' => 'Philippians 2  19-30 Life Principle 6  Surrounding Yourself With A Mature Christian Support Group.pptx',
                'count' => 190,
            ],
            [
                'name' => 'Philippians 3  1-11 Life Principle 7  Standing on the Grace of God Plus Nothing.pptx',
                'count' => 118,
            ],
            [
                'name' => 'Philippians 3  1-11 Life Principle 7  Standing on the Grace of God Plus Nothing.pdf',
                'count' => 76,
            ],
            [
                'name' => 'The Proof of the Existence of God - Part 1.pdf',
                'count' => 131,
            ],
            [
                'name' => 'The Proof of the Existence of God - Part 1.ppt',
                'count' => 135,
            ],
            [
                'name' => 'The Proof of the Existence of God - Part 2.pdf',
                'count' => 208,
            ],
            [
                'name' => 'The Proof of the Existence of God - Part 2.ppt',
                'count' => 198,
            ],
            [
                'name' => 'The Proof of the Existence of God - Part 3.pdf',
                'count' => 184,
            ],
            [
                'name' => 'The Proof of the Existence of God - Part 3.ppt',
                'count' => 194,
            ],
            [
                'name' => 'Dead Sea Scrolls.pdf',
                'count' => 224,
            ],
            [
                'name' => 'Dead Sea Scrolls.ppt',
                'count' => 237,
            ],
            [
                'name' => 'The Four Great Questions of Life.pdf',
                'count' => 192,
            ],
            [
                'name' => 'The Four Great Questions of Life.ppt',
                'count' => 223,
            ],
            [
                'name' => 'A Christian Bucket List.pdf',
                'count' => 122,
            ],
            [
                'name' => 'A Christian Bucket List.ppt',
                'count' => 110,
            ],
            [
                'name' => 'The Fifty Things That Happened To You The Moment You Are Saved.pdf',
                'count' => 101,
            ],
            [
                'name' => 'The Fifty Things That Happened To You The Moment You Are Saved.ppt',
                'count' => 90,
            ],
            [
                'name' => 'Daniels Seventy Weeks.pdf',
                'count' => 476,
            ],
            [
                'name' => 'Daniels Seventy Weeks.ppt',
                'count' => 313,
            ],
            [
                'name' => 'The Role of The Christian Parent in Helping Their Children Find a Spouse.pdf',
                'count' => 92,
            ],
            [
                'name' => 'The Role of The Christian Parent in Helping Their Children Find a Spouse.ppt',
                'count' => 142,
            ],
            [
                'name' => 'How To Understand The Big Picture of The Bible in One Hour.pdf',
                'count' => 154,
            ],
            [
                'name' => 'How To Understand The Big Picture of The Bible in One Hour .pptx',
                'count' => 158,
            ],
            [
                'name' => 'How to make a cult - Part 1.PDF',
                'count' => 317,
            ],
            [
                'name' => 'How to make a cult - Part 1.ppt',
                'count' => 305,
            ],
            [
                'name' => 'How to make a cult - Part 2.pdf',
                'count' => 297,
            ],
            [
                'name' => 'How to make a cult - Part 2.ppt',
                'count' => 289,
            ],
            [
                'name' => 'How to make a cult - Part 3.ppt',
                'count' => 314,
            ],
            [
                'name' => 'How to make a cult - Part 3.pdf',
                'count' => 287,
            ],
            [
                'name' => 'Biblically Constructing the Real Man - Intro - Part 1.ppt',
                'count' => 75,
            ],
            [
                'name' => 'Biblically Constructing the Real Man - Intro - Part 1.pdf',
                'count' => 64,
            ],
            [
                'name' => 'Biblically Constructing the Real Man - Part 2 The first ten traits.ppt',
                'count' => 58,
            ],
            [
                'name' => 'Biblically Constructing the Real Man - Part 2 The first ten traits.pdf',
                'count' => 59,
            ],
            [
                'name' => 'Biblically Constructing the Real Man - Part 3 The second ten traits.ppt',
                'count' => 54,
            ],
            [
                'name' => 'Biblically Constructing the Real Man - Part 3 The second ten traits.pdf',
                'count' => 50,
            ],
            [
                'name' => 'Biblically Constructing the Real Man - Part 4 The Masculinity of Jesus.ppt',
                'count' => 206,
            ],
            [
                'name' => 'Biblically Constructing the Real Man - Part 4 The Masculinity of Jesus.pdf',
                'count' => 56,
            ],
            [
                'name' => 'Hitting The Rock - A Biblical Understanding of Anger - Part 1.ppt',
                'count' => 99,
            ],
            [
                'name' => 'Hitting The Rock - A Biblical Understanding of Anger - Part 1.pdf',
                'count' => 94,
            ],
            [
                'name' => 'Hitting The Rock - A Biblical Understanding of Anger - Part 2.ppt',
                'count' => 106,
            ],
            [
                'name' => 'Hitting The Rock - A Biblical Understanding of Anger - Part 2.pdf',
                'count' => 96,
            ],
            [
                'name' => 'Hitting The Rock - A Biblical Understanding of Anger - Part 3.ppt',
                'count' => 94,
            ],
            [
                'name' => 'Hitting The Rock - A Biblical Understanding of Anger - Part 3.pdf',
                'count' => 92,
            ],
            [
                'name' => 'Hitting The Rock - A Biblical Understanding of Anger - Part 4.ppt',
                'count' => 360,
            ],
            [
                'name' => 'Hitting The Rock - A Biblical Understanding of Anger - Part 4.pdf',
                'count' => 102,
            ],
            [
                'name' => 'Hitting The Rock - A Biblical Understanding of Anger - Part 5.ppt',
                'count' => 96,
            ],
            [
                'name' => 'Hitting The Rock - A Biblical Understanding of Anger - Part 5.pdf',
                'count' => 96,
            ],
            [
                'name' => 'Jonah and Anger Management.ppt',
                'count' => 111,
            ],
            [
                'name' => 'Jonah and Anger Management.pdf',
                'count' => 115,
            ],
            [
                'name' => 'The Believer’s Right Tude - Part 1.pdf',
                'count' => 66,
            ],
            [
                'name' => 'The Believer’s Right Tude - Part 1.ppt',
                'count' => 73,
            ],
            [
                'name' => 'The Believer’s Right Tude - Part 2.pdf',
                'count' => 69,
            ],
            [
                'name' => 'The Believer’s Right Tude - Part 2.ppt',
                'count' => 84,
            ],
            [
                'name' => 'The Believer’s Right Tude - Part 3.ppt',
                'count' => 88,
            ],
            [
                'name' => 'The Believers Right Tude - Part 3.pdf',
                'count' => 86,
            ],
            [
                'name' => 'Church Discipline - Step one.ppt',
                'count' => 99,
            ],
            [
                'name' => 'Church Discipline - Step one.pdf',
                'count' => 92,
            ],
            [
                'name' => 'Church Discipline - Step two through four.ppt',
                'count' => 82,
            ],
            [
                'name' => 'Church Discipline - Step two through four.pdf',
                'count' => 80,
            ],
            [
                'name' => 'Church Discipline - Conclusion.ppt',
                'count' => 109,
            ],
            [
                'name' => 'Church Discipline - Conclusion.pdf',
                'count' => 93,
            ],
            [
                'name' => 'The Church - The Seven Word Pictures God Uses To Describe The Church Part 1.ppt',
                'count' => 46,
            ],
            [
                'name' => 'The Church - The Seven Word Pictures God Uses To Describe The Church Part 1.pdf',
                'count' => 58,
            ],
            [
                'name' => 'The Church - The purpose of the Church Part 2.ppt',
                'count' => 59,
            ],
            [
                'name' => 'The Church - The purpose of the Church Part 2.pdf',
                'count' => 61,
            ],
            [
                'name' => 'The Church - Essentials and Freedom Part 3.ppt',
                'count' => 92,
            ],
            [
                'name' => 'The Church - Essentials and Freedom Part 3.pdf',
                'count' => 69,
            ],
            [
                'name' => 'The Church - The First Five Essentials Part 4.ppt',
                'count' => 85,
            ],
            [
                'name' => 'The Church - The First Five Essentials Part 4.pdf',
                'count' => 97,
            ],
            [
                'name' => 'The Church - The Second Five Essentials Part 5.ppt',
                'count' => 74,
            ],
            [
                'name' => 'The Church - The Second Five Essentials Part 5.pdf',
                'count' => 82,
            ],
            [
                'name' => 'The Church - The Matrix - Comparing the essentials with YLFC  Part 6.ppt',
                'count' => 211,
            ],
            [
                'name' => 'The Church - The Matrix - Comparing the essentials with YLFC  Part 6.pdf',
                'count' => 78,
            ],
            [
                'name' => 'The Church - The Seven Churches of Asia Part 7.ppt',
                'count' => 93,
            ],
            [
                'name' => 'The Church - The Seven Churches of Asia Part 7.pdf',
                'count' => 86,
            ],
            [
                'name' => 'The Church - Evaluating the Seeker Friendly Movemant   Part 8.ppt',
                'count' => 75,
            ],
            [
                'name' => 'The Church - Evaluating the Seeker Friendly Movemant   Part 8.pdf',
                'count' => 65,
            ],
            [
                'name' => 'The Church - The Ten Largest Churches in America Part 9.ppt',
                'count' => 66,
            ],
            [
                'name' => 'The Church - The Ten Largest Churches in America Part 9.pdf',
                'count' => 65,
            ],
            [
                'name' => 'End Times Series - Intro Part 1.pptx',
                'count' => 128,
            ],
            [
                'name' => 'End Times Series - Intro Part 1.pdf',
                'count' => 117,
            ],
            [
                'name' => 'Kingdom Fever Part 2 .pptx',
                'count' => 125,
            ],
            [
                'name' => 'Kingdom Fever Part 2 .pdf',
                'count' => 135,
            ],
            [
                'name' => 'Israel in Prophecy Part 3.pptx',
                'count' => 143,
            ],
            [
                'name' => 'Israel in Prophecy Part 3.pdf',
                'count' => 124,
            ],
            [
                'name' => 'Ezekiel 38-39 Gog and Magog Part 4 .pptx',
                'count' => 119,
            ],
            [
                'name' => 'Ezekiel 38-39 Gog and Magog Part 4 .pdf',
                'count' => 108,
            ],
            [
                'name' => 'Daniel 2, 7, and 9 Part 5.pptx',
                'count' => 97,
            ],
            [
                'name' => 'Daniel 2, 7, and 9 Part 5.pdf',
                'count' => 103,
            ],
            [
                'name' => 'The Olivet Discourse Part 6.pptx',
                'count' => 129,
            ],
            [
                'name' => 'The Olivet Discourse Part 6.pdf',
                'count' => 130,
            ],
            [
                'name' => 'New Testament Writiers On The End-Times Part 7.pptx',
                'count' => 79,
            ],
            [
                'name' => 'New Testament Writiers On The End-Times Part 7.pdf',
                'count' => 86,
            ],
            [
                'name' => 'The Book of Revelation Part 8.pptx',
                'count' => 115,
            ],
            [
                'name' => 'The Book of Revelation Part 8.pdf',
                'count' => 121,
            ],
            [
                'name' => 'Philippians 3  12-21 Life Principle 8  Passionately Pursuing Perfection.pptx',
                'count' => 222,
            ],
            [
                'name' => 'Philippians 3  12-21 Life Principle 8  Passionately Pursuing Perfection.pdf',
                'count' => 109,
            ],
            [
                'name' => 'Ten of the most comforting passages in the Bible.ppt',
                'count' => 97,
            ],
            [
                'name' => 'Ten of the most comforting passages in the Bible.pdf',
                'count' => 87,
            ],
            [
                'name' => 'Five of Church Historys Worse Ideas - Part 1.ppt',
                'count' => 101,
            ],
            [
                'name' => 'Five of Church Historys Worse Ideas - Part 1.pdf',
                'count' => 106,
            ],
            [
                'name' => 'Five of Church Historys Worse Ideas - The Inquistion Part 2.ppt',
                'count' => 88,
            ],
            [
                'name' => 'Five of Church Historys Worse Ideas - The Inquistion Part 2.pdf',
                'count' => 98,
            ],
            [
                'name' => 'Five of Church Historys Worse Ideas - England making the Anglican Church the State Church Part 3.ppt',
                'count' => 99,
            ],
            [
                'name' => 'Five of Church Historys Worse Ideas  - England making the Anglican Church the State Church Part 3.pdf',
                'count' => 73,
            ],
            [
                'name' => 'The Right of God to Rule My Life - Part 1.pdf',
                'count' => 100,
            ],
            [
                'name' => 'The Right of God to Rule My Life - Part 1.ppt',
                'count' => 95,
            ],
            [
                'name' => 'Five of Church Historys Worse Ideas - Prohiibition Part 4.pdf',
                'count' => 110,
            ],
            [
                'name' => 'Five of Church Historys Worse Ideas - Prohiibition Part 4.ppt',
                'count' => 102,
            ],
            [
                'name' => 'The Right of God to Rule My Life - Part 2.ppt',
                'count' => 174,
            ],
            [
                'name' => 'The Right of God to Rule My Life - Part 2.pdf',
                'count' => 86,
            ],
            [
                'name' => 'The Right of God to Rule My Life - Part 3.ppt',
                'count' => 107,
            ],
            [
                'name' => 'The Right of God to Rule My Life - Part 3.pdf',
                'count' => 95,
            ],
            [
                'name' => 'The Right of God to Rule My Life - Part 4.ppt',
                'count' => 93,
            ],
            [
                'name' => 'The Right of God to Rule My Life - Part 4.pdf',
                'count' => 98,
            ],
            [
                'name' => 'Philippians 4  1-3 Life Principle 9 Living with others in harmony and not conflict Part 1 .pptx',
                'count' => 136,
            ],
            [
                'name' => 'Philippians 4  1-3 Life Principle 9 Living with others in harmony and not conflict Part 1 .pdf',
                'count' => 91,
            ],
            [
                'name' => 'Christian Habit Building - Part 1.pptx',
                'count' => 168,
            ],
            [
                'name' => 'Christian Habit Building - Part 1.pdf',
                'count' => 169,
            ],
            [
                'name' => 'Philippians 4  1-3 Life Principle 9 Living with others in harmony and not conflict Part 2 .pptx',
                'count' => 187,
            ],
            [
                'name' => 'Philippians 4  1-3 Life Principle 9 Living with others in harmony and not conflict Part 2 .pdf',
                'count' => 94,
            ],
            [
                'name' => 'Phil 4 1-3 Part 2.mp3',
                'count' => 141,
            ],
            [
                'name' => 'PRIDE AND HUMILITY 2.ppt',
                'count' => 80,
            ],
            [
                'name' => 'PRIDE AND HUMILITY 2.pdf',
                'count' => 87,
            ],
            [
                'name' => 'Christian Habit Building - Part 2.pptx',
                'count' => 165,
            ],
            [
                'name' => 'Christian Habit Building - Part 2.pdf',
                'count' => 151,
            ],
            [
                'name' => 'Christian Habit Building - Part 3.pptx',
                'count' => 167,
            ],
            [
                'name' => 'Christian Habit Building - Part 3.pdf',
                'count' => 156,
            ],
            [
                'name' => 'Christian Habit Building - Part 4.pptx',
                'count' => 166,
            ],
            [
                'name' => 'Christian Habit Building - Part 4.pdf',
                'count' => 158,
            ],
            [
                'name' => 'The Balance of Being and Doing in The Believer’s Life - Part 1.ppt',
                'count' => 101,
            ],
            [
                'name' => 'The Balance of Being and Doing in The Believer’s Life - Part 1.pdf',
                'count' => 90,
            ],
            [
                'name' => 'II Corinthians - Intro.ppt',
                'count' => 90,
            ],
            [
                'name' => 'II Corinthians - Intro.pdf',
                'count' => 76,
            ],
            [
                'name' => 'II Corinthians 1  1-11 - Biblical Insights about the Comfort of God Born On the Front Lines.ppt',
                'count' => 41,
            ],
            [
                'name' => 'II Corinthians 1  1-11 - Biblical Insights about the Comfort of God Born On the Front Lines.pdf',
                'count' => 39,
            ],
            [
                'name' => 'Ryan Buttes Corinth Presentation.pdf',
                'count' => 159,
            ],
            [
                'name' => 'II Corinthians 2 1-10 - The Process of Restoration.ppt',
                'count' => 83,
            ],
            [
                'name' => 'II Corinthians 2 1-10 - The Process of Restoration.pdf',
                'count' => 78,
            ],
            [
                'name' => 'II Corinthians 1 12-24 - How Not To Be A Promise Breaker.ppt',
                'count' => 58,
            ],
            [
                'name' => 'II Corinthians 1 12-24 - How Not To Be A Promise Breaker.pdf',
                'count' => 68,
            ],
            [
                'name' => 'II Corinthians  3 1-6 The 67th Book of the Bible.ppt',
                'count' => 68,
            ],
            [
                'name' => 'II Corinthians  3 1-6 The 67th Book of the Bible.pdf',
                'count' => 78,
            ],
            [
                'name' => 'II Corinthians  3 7-18 Why Some People Reject The Gospel - Part 1.ppt',
                'count' => 60,
            ],
            [
                'name' => 'II Corinthians  3 7-18 Why Some People Reject The Gospel - Part 1.pdf',
                'count' => 43,
            ],
            [
                'name' => 'II Corinthians  3 7-18 Why Some People Reject The Gospel - Part 2.ppt',
                'count' => 48,
            ],
            [
                'name' => 'II Corinthians  3 7-18 Why Some People Reject The Gospel - Part 2.pdf',
                'count' => 43,
            ],
            [
                'name' => 'II Corinthians  4 1-6 Seven things to look for in a minister.pdf',
                'count' => 53,
            ],
            [
                'name' => 'II Corinthians  4 1-6 Seven things to look for in a minister.ppt',
                'count' => 72,
            ],
            [
                'name' => 'II Corinthians  4 7-12 Unleashing the power of God in my life.ppt',
                'count' => 56,
            ],
            [
                'name' => 'II Corinthians  4 7-12 Unleashing the power of God in my life.pdf',
                'count' => 51,
            ],
            [
                'name' => 'II Corinthians  4  13-18 Your Not Getting Older You Are Getting Better.ppt',
                'count' => 50,
            ],
            [
                'name' => 'II Corinthians  4  13-18 Your Not Getting Older You Are Getting Better.pdf',
                'count' => 60,
            ],
            [
                'name' => 'II Corinthians  5 1-10 This Old House.ppt',
                'count' => 95,
            ],
            [
                'name' => 'II Corinthians  5 1-10 This Old House.pdf',
                'count' => 69,
            ],
            [
                'name' => 'II Corinthians  5 11-21 A New Way Of Looking At People Part 3.ppt',
                'count' => 55,
            ],
            [
                'name' => 'II Corinthians  5 11-21 A New Way Of Looking At People Part 3.pdf',
                'count' => 62,
            ],
            [
                'name' => 'II Corinthians  5 11-21 A New Way Of Looking At People Part 1.ppt',
                'count' => 53,
            ],
            [
                'name' => 'II Corinthians  5 11-21 A New Way Of Looking At People Part 1.pdf',
                'count' => 53,
            ],
            [
                'name' => 'II Corinthians  5 11-21 Reconciliation - The Ministry of Healing Broken Relationships 2.ppt',
                'count' => 89,
            ],
            [
                'name' => 'II Corinthians  5 11-21 Reconciliation - The Ministry of Healing Broken Relationships 2.pdf',
                'count' => 75,
            ],
            [
                'name' => 'II Corinthians  6 1-13 The Five Laws of Spiritual Paradoxes of The Christian Life.ppt',
                'count' => 96,
            ],
            [
                'name' => 'II Corinthians  6 1-13 The Five Laws of Spiritual Paradoxes of The Christian Life.pdf',
                'count' => 70,
            ],
            [
                'name' => 'II Corinthians  6 14-18 The Four Mistakes Christians Make About With Whom They Spend Time.ppt',
                'count' => 67,
            ],
            [
                'name' => 'II Corinthians  6 14-18 The Four Mistakes Christians Make About With Whom They Spend Time.pdf',
                'count' => 53,
            ],
            [
                'name' => 'II Corinthians  7 1-16 What True Biblical Repentance Looks Like.ppt',
                'count' => 63,
            ],
            [
                'name' => 'II Corinthians  7 1-16 What True Biblical Repentance Looks Like.pdf',
                'count' => 61,
            ],
            [
                'name' => 'II Corinthians 8-9 - Introduction - Part I.ppt',
                'count' => 80,
            ],
            [
                'name' => 'II Corinthians 8-9 - Introduction - Part I.pdf',
                'count' => 73,
            ],
            [
                'name' => 'II Corinthians 8-9 Introduction - The Promise Paul Would Not Break - Part II.ppt',
                'count' => 43,
            ],
            [
                'name' => 'II Corinthians 8-9 Introduction - The Promise Paul Would Not Break - Part II.pdf',
                'count' => 49,
            ],
            [
                'name' => 'II Corinthians 8-9 Twenty Biblical Principles of Sound Financial Giving - Part III.ppt',
                'count' => 57,
            ],
            [
                'name' => 'II Corinthians 8-9 Twenty Biblical Principles of Sound Financial Giving - Part III.pdf',
                'count' => 49,
            ],
            [
                'name' => 'II Corinthians 10 - Ten Traits of the Christian Warrior - Part 1.ppt',
                'count' => 58,
            ],
            [
                'name' => 'II Corinthians 10 - Ten Traits of the Christian Warrior - Part 1.PDF',
                'count' => 59,
            ],
            [
                'name' => 'II Corinthians 10 - Ten Traits of the Christian Warrior - Part 2.ppt',
                'count' => 79,
            ],
            [
                'name' => 'II Corinthians 10 - Ten Traits of the Christian Warrior - Part 2.PDF',
                'count' => 64,
            ],
            [
                'name' => 'II Corinthians 10 - Ten Traits of the Christian Warrior - Part 3.ppt',
                'count' => 54,
            ],
            [
                'name' => 'II Corinthians 10 - Ten Traits of the Christian Warrior - Part 3.PDF',
                'count' => 57,
            ],
            [
                'name' => 'II Corinthians 10 - Ten Traits of the Christian Warrior - Part 4.ppt',
                'count' => 70,
            ],
            [
                'name' => 'II Corinthians 10 - Ten Traits of the Christian Warrior - Part 4.PDF',
                'count' => 181,
            ],
            [
                'name' => 'II Corinthians 10 - Ten Traits of the Christian Warrior - Part 5.ppt',
                'count' => 71,
            ],
            [
                'name' => 'II Corinthians 10 - Ten Traits of the Christian Warrior - Part 5.PDF',
                'count' => 58,
            ],
            [
                'name' => 'II Corinthians 11 1-20 A Recipe for Spiritual Disaster - Part 1.ppt',
                'count' => 69,
            ],
            [
                'name' => 'II Corinthians 11 1-20 A Recipe for Spiritual Disaster - Part 1.pdf',
                'count' => 68,
            ],
            [
                'name' => 'II Corinthians 11 1-20 A Recipe for Spiritual Disaster - Part 2.ppt',
                'count' => 71,
            ],
            [
                'name' => 'II Corinthians 11 1-20 A Recipe for Spiritual Disaster - Part 2.pdf',
                'count' => 68,
            ],
            [
                'name' => 'II Corinthians 11 1-20 A Recipe for Spiritual Disaster - Part 3.ppt',
                'count' => 62,
            ],
            [
                'name' => 'II Corinthians 11 1-20 A Recipe for Spiritual Disaster - Part 3.pdf',
                'count' => 72,
            ],
            [
                'name' => 'II Corinthians 11 1-20 A Recipe for Spiritual Disaster - Part 4.ppt',
                'count' => 67,
            ],
            [
                'name' => 'II Corinthians 11 1-20 A Recipe for Spiritual Disaster - Part 4.pdf',
                'count' => 153,
            ],
            [
                'name' => 'II Corinthians 11 21-33 Three Qualities Missing From Church Applications.ppt',
                'count' => 70,
            ],
            [
                'name' => 'II Corinthians 11 21-33 Three Qualities Missing From Church Applications.pdf',
                'count' => 58,
            ],
            [
                'name' => 'II Corinthians 12 1-10 A Thorn in the Flesh Part 1.ppt',
                'count' => 76,
            ],
            [
                'name' => 'II Corinthians 12 1-10 A Thorn in the Flesh Part 1.pdf',
                'count' => 80,
            ],
            [
                'name' => 'II Corinthians 12 1-10 A Thorn in the Flesh Part 2.ppt',
                'count' => 100,
            ],
            [
                'name' => 'II Corinthians 12 1-10 A Thorn in the Flesh Part 2.pdf',
                'count' => 91,
            ],
            [
                'name' => 'II Corinthians 12 11 thru 13 14 Pleading With Christians In Sin To Follow God And Obey The Truth.ppt',
                'count' => 53,
            ],
            [
                'name' => 'II Corinthians 12 11 thru 13 14 Pleading With Christians In Sin To Follow God And Obey The Truth.PDF',
                'count' => 61,
            ],
            [
                'name' => 'True Spirituality - The Three Types of Homo Sapiens - Part 1.ppt',
                'count' => 74,
            ],
            [
                'name' => 'True Spirituality - The Three Types of Homo Sapiens - Part 1.pdf',
                'count' => 71,
            ],
            [
                'name' => 'True Spirituality - The Treasure Chest of Every Christian - Part 2.ppt',
                'count' => 53,
            ],
            [
                'name' => 'True Spirituality - The Treasure Chest of Every Christian - Part 2.pdf',
                'count' => 47,
            ],
            [
                'name' => 'True Spirituality - Nature of False Spirituality - Part 3.ppt',
                'count' => 49,
            ],
            [
                'name' => 'True Spirituality - Nature of False Spirituality - Part 3.pdf',
                'count' => 53,
            ],
            [
                'name' => 'True Spirituality - Being Spiritually Smart - Part 4.ppt',
                'count' => 71,
            ],
            [
                'name' => 'True Spirituality - Being Spiritually Smart - Part 4.pdf',
                'count' => 80,
            ],
            [
                'name' => 'True Spirituality - Being Spiritually Broken - Part 5.ppt',
                'count' => 43,
            ],
            [
                'name' => 'True Spirituality - Being Spiritually Broken - Part 5.pdf',
                'count' => 50,
            ],
            [
                'name' => 'True Spirituality - Being Spiritually Broken Christian - Part 5.ppt',
                'count' => 44,
            ],
            [
                'name' => 'True Spirituality - Being Spiritually Broken Christian - Part 5.pdf',
                'count' => 50,
            ],
            [
                'name' => 'True Spirituality - The War of the Spirit and the Flesh - Part 6.ppt',
                'count' => 72,
            ],
            [
                'name' => 'True Spirituality - The War of the Spirit and the Flesh - Part 6.pdf',
                'count' => 82,
            ],
            [
                'name' => 'True Spirituality - A Heart of a Servant - Part 7.ppt',
                'count' => 67,
            ],
            [
                'name' => 'True Spirituality - A Heart of a Servant - Part 7.pdf',
                'count' => 69,
            ],
            [
                'name' => 'True Spirituality - An Intimate Heart For God - Part 8.ppt',
                'count' => 61,
            ],
            [
                'name' => 'True Spirituality - An Intimate Heart For God - Part 8.pdf',
                'count' => 74,
            ],
            [
                'name' => 'True Spirituality - The Big Five Defining Moments of Your Life - Part 9.ppt',
                'count' => 65,
            ],
            [
                'name' => 'True Spirituality - The Big Five Defining Moments of Your Life - Part 9.pdf',
                'count' => 88,
            ],
            [
                'name' => 'The Purpose of My Purpose - Part 1.pptx',
                'count' => 107,
            ],
            [
                'name' => 'The Purpose of My Purpose - Part 1.pdf',
                'count' => 105,
            ],
            [
                'name' => 'The Purpose of My Purpose - Part 2.pptx',
                'count' => 115,
            ],
            [
                'name' => 'The Purpose of My Purpose - Part 2.pdf',
                'count' => 115,
            ],
            [
                'name' => 'The Purpose of My Purpose - Part 3.pptx',
                'count' => 115,
            ],
            [
                'name' => 'The Purpose of My Purpose - Part 3.pdf',
                'count' => 107,
            ],
            [
                'name' => 'The Purpose of My Purpose - Part 4.pptx',
                'count' => 84,
            ],
            [
                'name' => 'The Purpose of My Purpose - Part 4.pdf',
                'count' => 87,
            ],
            [
                'name' => 'The Purpose of My Purpose - Part 5.pptx',
                'count' => 145,
            ],
            [
                'name' => 'The Purpose of My Purpose - Part 5.pdf',
                'count' => 133,
            ],
            [
                'name' => 'The Purpose of My Purpose - Part 6.pptx',
                'count' => 103,
            ],
            [
                'name' => 'The Purpose of My Purpose - Part 6.pdf',
                'count' => 100,
            ],
            [
                'name' => 'The Purpose of My Purpose - Part 7.pptx',
                'count' => 139,
            ],
            [
                'name' => 'The Purpose of My Purpose - Part 7.pdf',
                'count' => 124,
            ],
            [
                'name' => 'Life Purpose Statement  Presentation 2009 - Part 8.ppt.pptx',
                'count' => 91,
            ],
            [
                'name' => 'Life Purpose Statement  Presentation 2009 - Part 8.ppt.pdf',
                'count' => 94,
            ],
            [
                'name' => 'Larry and Janet Woessner testimony.mp3',
                'count' => 142,
            ],
            [
                'name' => 'The Book of Revelation - Introduction - Part 1.pptx',
                'count' => 87,
            ],
            [
                'name' => 'The Book of Revelation - Introduction - Part 1.pdf',
                'count' => 82,
            ],
            [
                'name' => 'The Book of Revelation - 1-7 Part 2.pptx',
                'count' => 129,
            ],
            [
                'name' => 'The Book of Revelation - 1-7 Part 2.pdf',
                'count' => 92,
            ],
            [
                'name' => 'The Book of Revelation 8-13 - Part 3.pptx',
                'count' => 104,
            ],
            [
                'name' => 'The Book of Revelation 8-13 - Part 3.pdf',
                'count' => 94,
            ],
            [
                'name' => 'The Book of Revelation - 14-18 - Part 4.pptx',
                'count' => 99,
            ],
            [
                'name' => 'The Book of Revelation - 14-18 - Part 4.pdf',
                'count' => 103,
            ],
            [
                'name' => 'The Book of Revelation - 19-20 - Part 5.pptx',
                'count' => 97,
            ],
            [
                'name' => 'The Book of Revelation - 19-20 - Part 5.pdf',
                'count' => 102,
            ],
            [
                'name' => 'The Book of Revelation - 21-22 - Part 6.pptx',
                'count' => 98,
            ],
            [
                'name' => 'The Book of Revelation - 21-22 - Part 6.pdf',
                'count' => 101,
            ],
            [
                'name' => 'The Book of Revelation - 21-22 - Part 7.pptx',
                'count' => 97,
            ],
            [
                'name' => 'The Book of Revelation - 21-22 - Part 7.pdf',
                'count' => 88,
            ],
            [
                'name' => 'Introduction - Why Marriage is so difficult.pptx',
                'count' => 140,
            ],
            [
                'name' => 'Introduction - Why Marriage is so difficult.pdf',
                'count' => 118,
            ],
            [
                'name' => 'Key 1 The Ten Most Foundational Teachings on Marriage.pptx',
                'count' => 105,
            ],
            [
                'name' => 'Key 1 The Ten Most Foundational Teachings on Marriage.pdf',
                'count' => 92,
            ],
            [
                'name' => 'Key 2  The Responsive Love Principle.pptx',
                'count' => 143,
            ],
            [
                'name' => 'Key 2  The Responsive Love Principle.pdf',
                'count' => 133,
            ],
            [
                'name' => 'Key 3 Domisticating Your Emotions.pptx',
                'count' => 142,
            ],
            [
                'name' => 'Key 3 Domisticating Your Emotions.pdf',
                'count' => 131,
            ],
            [
                'name' => 'Key 4 Making your spouse you boyfriend or girlfriend.pptx',
                'count' => 82,
            ],
            [
                'name' => 'Key 4 Making your spouse you boyfriend or girlfriend.pdf',
                'count' => 79,
            ],
            [
                'name' => 'Key 5 Lets Make A Deal.pptx',
                'count' => 122,
            ],
            [
                'name' => 'Key 5 Lets Make A Deal.pdf',
                'count' => 135,
            ],
            [
                'name' => 'Key 6 Rules of Engagement.pptx',
                'count' => 140,
            ],
            [
                'name' => 'Key 6 Rules of Engagement.pdf',
                'count' => 135,
            ],
            [
                'name' => 'Key 7 Forgiveness in Marriage.pptx',
                'count' => 101,
            ],
            [
                'name' => 'Key 7 Forgiveness in Marriage.pdf',
                'count' => 113,
            ],
            [
                'name' => 'Key 8 Healthy Romantic and Lovemaking.pptx',
                'count' => 138,
            ],
            [
                'name' => 'Key 8 Healthy Romantic and Lovemaking.pdf',
                'count' => 124,
            ],
            [
                'name' => 'The Cycle of Love and Respect in Marriage.ppt',
                'count' => 165,
            ],
            [
                'name' => 'The Cycle of Love and Respect in Marriage.pdf',
                'count' => 171,
            ],
            [
                'name' => 'Philosophy of Sex in the Bible.ppt',
                'count' => 130,
            ],
            [
                'name' => 'Philosophy of Sex in the Bible.PDF',
                'count' => 117,
            ],
            [
                'name' => 'Mr Testosterone Marries Ms Estrogen.ppt',
                'count' => 194,
            ],
            [
                'name' => 'Mr Testosterone Marries Ms Estrogen.pdf',
                'count' => 163,
            ],
            [
                'name' => 'Dear Lord, If You Gave Me My Sex Drive Then Why Does My Wife Sex Drive Not Match.ppt',
                'count' => 68,
            ],
            [
                'name' => 'Dear Lord, If You Gave Me My Sex Drive Then Why Does My Wife Sex Drive Not Match.pdf',
                'count' => 145,
            ],
            [
                'name' => 'Philemon - Part I.ppt',
                'count' => 125,
            ],
            [
                'name' => 'Philemon - Part I.pdf',
                'count' => 48,
            ],
            [
                'name' => 'Philemon - Part II.ppt',
                'count' => 51,
            ],
            [
                'name' => 'Philemon - Part II.pdf',
                'count' => 50,
            ],
            [
                'name' => 'Philemon - Part III.ppt',
                'count' => 46,
            ],
            [
                'name' => 'Philemon - Part III.pdf',
                'count' => 68,
            ],
            [
                'name' => 'Phil  4 1-3 Part 3.mp3',
                'count' => 122,
            ],
            [
                'name' => 'Philippians 4  1-3   Life Principle 9 Living with others in harmony and not conflict Part 3 .pptx',
                'count' => 166,
            ],
            [
                'name' => 'Philippians 4  1-3   Life Principle 9 Living with others in harmony and not conflict Part 3 .pdf',
                'count' => 73,
            ],
            [
                'name' => 'PRIDE AND HUMILITY 1.ppt',
                'count' => 101,
            ],
            [
                'name' => 'PRIDE AND HUMILITY 1.pdf',
                'count' => 87,
            ],
            [
                'name' => 'PRIDE AND HUMILITY 3.ppt',
                'count' => 77,
            ],
            [
                'name' => 'PRIDE AND HUMILITY 3.pdf',
                'count' => 89,
            ],
            [
                'name' => 'PRIDE AND HUMILITY 4.ppt',
                'count' => 443,
            ],
            [
                'name' => 'PRIDE AND HUMILITY 4.pdf',
                'count' => 60,
            ],
            [
                'name' => 'The Five Self-Deceptions The Bible Warns About - Part 1.pptx',
                'count' => 95,
            ],
            [
                'name' => 'The Five Self-Deceptions The Bible Warns About - Part 1.pdf',
                'count' => 87,
            ],
            [
                'name' => 'The Five Self-Deceptions The Bible Warns About - Part 2.pptx',
                'count' => 99,
            ],
            [
                'name' => 'The Five Self-Deceptions The Bible Warns About - Part 2.pdf',
                'count' => 93,
            ],
            [
                'name' => 'The Five Self-Deceptions The Bible Warns About - Part 3.pptx',
                'count' => 94,
            ],
            [
                'name' => 'The Five Self-Deceptions The Bible Warns About - Part 3.pdf',
                'count' => 94,
            ],
            [
                'name' => 'The Five Self-Deceptions The Bible Warns About - Part 4.pptx',
                'count' => 114,
            ],
            [
                'name' => 'The Five Self-Deceptions The Bible Warns About - Part 4.pdf',
                'count' => 113,
            ],
            [
                'name' => 'The Five Self-Deceptions The Bible Warns About - Part 5.pptx',
                'count' => 117,
            ],
            [
                'name' => 'The Five Self-Deceptions The Bible Warns About - Part 5.pdf',
                'count' => 111,
            ],
            [
                'name' => 'The Balance of Being and Doing in The Believer’s Life - Part 2.ppt',
                'count' => 146,
            ],
            [
                'name' => 'The Balance of Being and Doing in The Believer’s Life - Part 2.pdf',
                'count' => 160,
            ],
            [
                'name' => 'The Balance of Being and Doing in The Believer’s Life - Part 3.ppt',
                'count' => 83,
            ],
            [
                'name' => 'The Balance of Being and Doing in The Believer’s Life - Part 3.pdf',
                'count' => 80,
            ],
            [
                'name' => 'The Balance of Being and Doing in The Believer’s Life - Part 4.ppt',
                'count' => 141,
            ],
            [
                'name' => 'The Balance of Being and Doing in The Believer’s Life - Part 4.pdf',
                'count' => 106,
            ],
            [
                'name' => 'The Five Faces of Forgiveness - Part 1.ppt',
                'count' => 113,
            ],
            [
                'name' => 'The Five Faces of Forgiveness - Part 1.pdf',
                'count' => 120,
            ],
            [
                'name' => 'The Five Faces of Forgiveness - Part 2.ppt',
                'count' => 190,
            ],
            [
                'name' => 'The Five Faces of Forgiveness - Part 2.pdf',
                'count' => 146,
            ],
            [
                'name' => 'The Five Faces of Forgiveness - Part 3.ppt',
                'count' => 122,
            ],
            [
                'name' => 'The Five Faces of Forgiveness - Part 3.pdf',
                'count' => 120,
            ],
            [
                'name' => 'The Five Faces of Forgiveness - Part 4.ppt',
                'count' => 211,
            ],
            [
                'name' => 'The Five Faces of Forgiveness - Part 4.pdf',
                'count' => 184,
            ],
            [
                'name' => 'The Fifty Things That Happened To You The Moment You Are Saved - Part I.ppt',
                'count' => 78,
            ],
            [
                'name' => 'The Fifty Things That Happened To You The Moment You Are Saved - Part I.pdf',
                'count' => 55,
            ],
            [
                'name' => 'The Fifty Things That Happened To You The Moment You Are Saved - Part II.ppt',
                'count' => 75,
            ],
            [
                'name' => 'The Fifty Things That Happened To You The Moment You Are Saved - Part II.pdf',
                'count' => 59,
            ],
            [
                'name' => 'The Fifty Things That Happened To You The Moment You Are Saved - Part III.ppt',
                'count' => 61,
            ],
            [
                'name' => 'The Fifty Things That Happened To You The Moment You Are Saved - Part III.pdf',
                'count' => 69,
            ],
            [
                'name' => 'The Fifty Things That Happened To You The Moment You Are Saved - Master.ppt',
                'count' => 90,
            ],
            [
                'name' => 'The Fifty Things That Happened To You The Moment You Are Saved - Master.pdf',
                'count' => 74,
            ],
            [
                'name' => 'The Biblical Understanding Of Wealth In The Old Testament - Master.ppt',
                'count' => 95,
            ],
            [
                'name' => 'The Biblical Understanding Of Wealth In The Old Testament - Master.pdf',
                'count' => 89,
            ],
            [
                'name' => 'Part 2 - Jesus On Ten Mammon Management Principles - Principles 1-3.ppt',
                'count' => 88,
            ],
            [
                'name' => 'Part 2 - Jesus On Ten Mammon Management Principles - Principles 1-3.pdf',
                'count' => 88,
            ],
            [
                'name' => 'Part 3 - Jesus On Ten Mammon Management Principles - Principles 4-5.ppt',
                'count' => 93,
            ],
            [
                'name' => 'Part 3 - Jesus On Ten Mammon Management Principles - Principles 4-5.pdf',
                'count' => 97,
            ],
            [
                'name' => 'Part 4 - Jesus On Ten Mammon Management Principles - Principles 6-10.ppt',
                'count' => 106,
            ],
            [
                'name' => 'Part 4 - Jesus On Ten Mammon Management Principles - Principles 6-10.pdf',
                'count' => 98,
            ],
            [
                'name' => 'Part 5 - II Corinthians 8-9 - Introduction.ppt',
                'count' => 188,
            ],
            [
                'name' => 'Part 5 - II Corinthians 8-9 - Introduction.pdf',
                'count' => 117,
            ],
            [
                'name' => 'Part 6 - II Corinthians 8-9 - The Promise Paul Would Not Break.ppt',
                'count' => 101,
            ],
            [
                'name' => 'Part 6 - II Corinthians 8-9 - The Promise Paul Would Not Break.pdf',
                'count' => 177,
            ],
            [
                'name' => 'Part 7 - II Corinthians 8-9 Twenty Biblical Principles of Sound Financial Giving.ppt',
                'count' => 77,
            ],
            [
                'name' => 'Part 7 - II Corinthians 8-9 Twenty Biblical Principles of Sound Financial Giving.pdf',
                'count' => 52,
            ],
            [
                'name' => 'Awards banquet for mothers of the Bible.ppt',
                'count' => 131,
            ],
            [
                'name' => 'Awards banquet for mothers of the Bible.pdf',
                'count' => 135,
            ],
            [
                'name' => 'Beatitudes Mt 5 1-12.ppt',
                'count' => 104,
            ],
            [
                'name' => 'Beatitudes Mt 5 1-12.pdf',
                'count' => 100,
            ],
            [
                'name' => 'Biblical Gift Giving.ppt',
                'count' => 140,
            ],
            [
                'name' => 'Biblical Gift Giving.pdf',
                'count' => 135,
            ],
            [
                'name' => 'Family Evangelism.ppt',
                'count' => 121,
            ],
            [
                'name' => 'Family Evangelism.pdf',
                'count' => 118,
            ],
            [
                'name' => 'Christian Accountability.ppt',
                'count' => 105,
            ],
            [
                'name' => 'Christian Accountability.pdf',
                'count' => 130,
            ],
            [
                'name' => 'Gratefulness.pptx',
                'count' => 151,
            ],
            [
                'name' => 'Gratefulness.pdf',
                'count' => 199,
            ],
            [
                'name' => 'Four Major Deterrents to Christians Sharing Their Faith.pptx',
                'count' => 130,
            ],
            [
                'name' => 'Four Major Deterrents to Christians Sharing Their Faith.pdf',
                'count' => 107,
            ],
            [
                'name' => 'John 9 - The Healing of the Blind Man.ppt',
                'count' => 123,
            ],
            [
                'name' => 'John 9 - The Healing of the Blind Man.pdf',
                'count' => 122,
            ],
            [
                'name' => 'The Problem of Evil.ppt',
                'count' => 228,
            ],
            [
                'name' => 'The Problem of Evil.pdf',
                'count' => 218,
            ],
            [
                'name' => 'The Blessings and the Curses.pptx',
                'count' => 200,
            ],
            [
                'name' => 'The Blessings and the Curses.pdf',
                'count' => 133,
            ],
            [
                'name' => 'The Emasculating of the Church.pptx',
                'count' => 164,
            ],
            [
                'name' => 'The Emasculating of the Church.pdf',
                'count' => 167,
            ],
            [
                'name' => 'Understanding Aunt Alices Bitterness.ppt',
                'count' => 203,
            ],
            [
                'name' => 'Understanding Aunt Alice Bitterness.pdf',
                'count' => 143,
            ],
            [
                'name' => 'Satans Ten Most Useful Lies.pdf',
                'count' => 134,
            ],
            [
                'name' => 'Satans Ten Most Useful Lies.ppt',
                'count' => 145,
            ],
            [
                'name' => 'True Biblical Faith.ppt',
                'count' => 135,
            ],
            [
                'name' => 'True Biblical Faith.pdf',
                'count' => 131,
            ],
            [
                'name' => 'Questions People Asked God in The Bible.ppt',
                'count' => 154,
            ],
            [
                'name' => 'Questions People Asked God in The Bible.pdf',
                'count' => 159,
            ],
            [
                'name' => 'The Ten Greastest Lies Christian Fathers Face.ppt',
                'count' => 81,
            ],
            [
                'name' => 'The Ten Greastest Lies Christian Fathers Face.pdf',
                'count' => 71,
            ],
            [
                'name' => 'The Ten God-Verbs That Define An Authentic Christ Follower.ppt',
                'count' => 149,
            ],
            [
                'name' => 'The Ten God-Verbs That Define An Authentic Christ Follower.pdf',
                'count' => 169,
            ],
            [
                'name' => 'Truth and Love.pptx',
                'count' => 192,
            ],
            [
                'name' => 'Truth and Love.pdf',
                'count' => 176,
            ],
            [
                'name' => 'Why God Wants His People Happy.pptx',
                'count' => 116,
            ],
            [
                'name' => 'Why God Wants His People Happy.pdf',
                'count' => 115,
            ],
            [
                'name' => 'The Prodigal Son and his Family - Luke 15 11-32.ppt',
                'count' => 106,
            ],
            [
                'name' => 'The Prodigal Son and his Family - Luke 15 11-32.pdf',
                'count' => 108,
            ],
            [
                'name' => 'The Balance Between Love and Discipline in Parenting.ppt',
                'count' => 143,
            ],
            [
                'name' => 'The Balance Between Love and Discipline in Parenting.pdf',
                'count' => 116,
            ],
            [
                'name' => 'Whose Land is It.ppt',
                'count' => 127,
            ],
            [
                'name' => 'Whose Land is It.pdf',
                'count' => 135,
            ],
            [
                'name' => 'The Importance of Iraq in the Bible.ppt',
                'count' => 110,
            ],
            [
                'name' => 'The Importance of Iraq in the Bible.pdf',
                'count' => 133,
            ],
            [
                'name' => 'Jesus and Two Apostles Prescription For Worry And Anxiety.ppt',
                'count' => 89,
            ],
            [
                'name' => 'Jesus and Two Apostles Prescription For Worry And Anxiety.pdf',
                'count' => 102,
            ],
            [
                'name' => 'The Legacy of a Father.ppt',
                'count' => 176,
            ],
            [
                'name' => 'The Legacy of a Father.pdf',
                'count' => 257,
            ],
            [
                'name' => 'When Adult Children Reject The Faith of Their Parents.ppt',
                'count' => 101,
            ],
            [
                'name' => 'When Adult Children Reject The Faith of Their Parents.pdf',
                'count' => 102,
            ],
            [
                'name' => 'Seven lessons on prayer that your Sunday School teachers may never have taught you.ppt',
                'count' => 125,
            ],
            [
                'name' => 'Seven lessons on prayer that your Sunday School teachers may never have taught you.pdf',
                'count' => 116,
            ],
            [
                'name' => 'Last Things - Great Bible Doctrines.ppt',
                'count' => 201,
            ],
            [
                'name' => 'Last Things - Great Bible Doctrines.pdf',
                'count' => 139,
            ],
            [
                'name' => 'Ten Grace Lessons From II Corinthians.ppt',
                'count' => 97,
            ],
            [
                'name' => 'Ten Grace Lessons From II Corinthians.pdf',
                'count' => 84,
            ],
            [
                'name' => 'Spiritual Warfare - Battlefront of Ideas.ppt',
                'count' => 146,
            ],
            [
                'name' => 'Spiritual Warfare - Battlefront of Ideas.pdf',
                'count' => 139,
            ],
            [
                'name' => 'Father God on Fathers Day.ppt',
                'count' => 151,
            ],
            [
                'name' => 'Father God on Fathers Day.pdf',
                'count' => 151,
            ],
            [
                'name' => 'Lady Wisdom on the Corinthian Epistles.pptx',
                'count' => 136,
            ],
            [
                'name' => 'Lady Wisdom on the Corinthian Epistles.pdf',
                'count' => 131,
            ],
            [
                'name' => 'Living with Difficult People.ppt',
                'count' => 98,
            ],
            [
                'name' => 'Living with Difficult People.pdf',
                'count' => 102,
            ],
            [
                'name' => 'Ten Great Chapters in the Bible.ppt',
                'count' => 204,
            ],
            [
                'name' => 'Ten Great Chapters in the Bible.pdf',
                'count' => 169,
            ],
            [
                'name' => 'The Names Given To The People Of God In The New Testament.pdf',
                'count' => 160,
            ],
            [
                'name' => 'The Names Given To The People Of God In The New Testament.pptx',
                'count' => 151,
            ],
            [
                'name' => 'The Christian Way of Handling Conflicts.ppt',
                'count' => 81,
            ],
            [
                'name' => 'The Christian Way of Handling Conflicts.pdf',
                'count' => 80,
            ],
            [
                'name' => 'A Brief Introduction to The Gospel of John.ppt',
                'count' => 115,
            ],
            [
                'name' => 'A Brief Introduction to The Gospel of John.pdf',
                'count' => 118,
            ],
            [
                'name' => 'The Prologue to the Gospel of John.ppt',
                'count' => 116,
            ],
            [
                'name' => 'The Prologue to the Gospel of John.pdf',
                'count' => 122,
            ],
            [
                'name' => 'Seeing Jesus in the mirror.ppt',
                'count' => 71,
            ],
            [
                'name' => 'Seeing Jesus in the mirror.pdf',
                'count' => 84,
            ],
            [
                'name' => 'Wrestling with the Sins of Your Father.ppt',
                'count' => 188,
            ],
            [
                'name' => 'Wrestling with the Sins of Your Father.pdf',
                'count' => 132,
            ],
            [
                'name' => 'The Ten Commandments.ppt',
                'count' => 101,
            ],
            [
                'name' => 'The Ten Commandments.pdf',
                'count' => 100,
            ],
            [
                'name' => 'What is Your Ministry.ppt',
                'count' => 62,
            ],
            [
                'name' => 'What is Your Ministry.pdf',
                'count' => 52,
            ],
            [
                'name' => 'Rules of Engagement - How to fight fair in marriage.pptx',
                'count' => 151,
            ],
            [
                'name' => 'Rules of Engagement - How to fight fair in marriage.pdf',
                'count' => 146,
            ],
            [
                'name' => 'In the Pursuit of Happiness.pdf',
                'count' => 170,
            ],
            [
                'name' => 'Phil 4 4 Part 1.mp3',
                'count' => 96,
            ],
            [
                'name' => 'Philippians 4  4 Life Principle 10  Choosing to live a life of joy - Part 1.pdf',
                'count' => 77,
            ],
            [
                'name' => 'Philippians 4  4 Life Principle 10  Choosing to live a life of joy - Part 1.pptx',
                'count' => 208,
            ],
            [
                'name' => 'Philippians 4  4 Life Principle 10  Choosing to live a life of joy - Part 2.pdf',
                'count' => 123,
            ],
            [
                'name' => 'Philippians 4  4 Life Principle 10  Choosing to live a life of joy - Part 2.pptx',
                'count' => 134,
            ],
            [
                'name' => 'Phil 4 4 Part 2.mp3',
                'count' => 129,
            ],
            [
                'name' => 'Philippians 4  4 Life Principle 10  Choosing to live a life of joy - Part 3.pptx',
                'count' => 262,
            ],
            [
                'name' => 'Philippians 4  4 Life Principle 10  Choosing to live a life of joy - Part 3.pdf',
                'count' => 79,
            ],
            [
                'name' => 'Philippians 4  4 Life Part 3.mp3',
                'count' => 128,
            ],
            [
                'name' => 'Philippians 4  4 Life Principle 10  Choosing to live a life of joy - Part 4.pptx',
                'count' => 107,
            ],
            [
                'name' => 'Philippians 4  4 Life Principle 10  Choosing to live a life of joy - Part 4.pdf',
                'count' => 100,
            ],
            [
                'name' => 'Phil 4 4 LP 10 Joy Part 4.mp3',
                'count' => 125,
            ],
            [
                'name' => 'Philippians 4  5-7 Life Principle 11 Letting Go of Anxiety - Part 1.pptx',
                'count' => 397,
            ],
            [
                'name' => 'Philippians 4  5-7 Life Principle 11 Letting Go of Anxiety - Part 1.pdf',
                'count' => 110,
            ],
            [
                'name' => 'Phil 4 5-7 Part 1.mp3',
                'count' => 129,
            ],
            [
                'name' => 'Philippians 4  5-7 Life Principle 11 Letting Go of Anxiety - Part 2.pptx',
                'count' => 213,
            ],
            [
                'name' => 'Philippians 4  5-7 Life Principle 11 Letting Go of Anxiety - Part 2.pdf',
                'count' => 95,
            ],
            [
                'name' => 'Phil 4 5-7 Part 2.mp3',
                'count' => 123,
            ],
            [
                'name' => 'Philippians 4 8-9 Life Principle 12  Protecting Your Thought Life.pptx',
                'count' => 287,
            ],
            [
                'name' => 'Philippians 4 8-9 Life Principle 12  Protecting Your Thought Life.pdf',
                'count' => 95,
            ],
            [
                'name' => 'Phil 4 8-9 LP 12 Thought Life.mp3',
                'count' => 132,
            ],
            [
                'name' => 'Philippians 4  10-13 Life Principle 13 Learning the Secret of Contentment - Part 1.pptx',
                'count' => 375,
            ],
            [
                'name' => 'Philippians 4  10-13 Life Principle 13 Learning the Secret of Contentment - Part 1.pdf',
                'count' => 98,
            ],
            [
                'name' => 'Phil 4 10-13 LP 13  Part 1.mp3',
                'count' => 136,
            ],
            [
                'name' => 'Philippians 4  10-13 Life Principle 13 Learning the Secret of Contentment - Part 2.pptx',
                'count' => 263,
            ],
            [
                'name' => 'Philippians 4  10-13 Life Principle 13 Learning the Secret of Contentment - Part 2.pdf',
                'count' => 94,
            ],
            [
                'name' => 'Phil 4 10-13 LP 13 Part 2.mp3',
                'count' => 193,
            ],
            [
                'name' => 'Philippians 4  14-19 Life Principle 14 Becoming a  Crazy Generous Believer.pptx',
                'count' => 190,
            ],
            [
                'name' => 'Philippians 4  14-19 Life Principle 14 Becoming a  Crazy Generous Believer.pdf',
                'count' => 91,
            ],
            [
                'name' => 'Phil 4 14-19 LP 14.mp3',
                'count' => 198,
            ],
            [
                'name' => 'Philippians 4  20-23 Life Principle 15 Connected to the Body of Christ.pptx',
                'count' => 139,
            ],
            [
                'name' => 'Philippians 4  20-23 Life Principle 15 Connected to the Body of Christ.pdf',
                'count' => 94,
            ],
            [
                'name' => 'Phil 4 20-23 LP 15.mp3',
                'count' => 198,
            ],
            [
                'name' => 'When Church Leaders Fail  You.pptx',
                'count' => 270,
            ],
            [
                'name' => 'When Church Leaders Fail  You.pdf',
                'count' => 224,
            ],
            [
                'name' => 'When Church Leaders Fail You.mp3',
                'count' => 385,
            ],
            [
                'name' => 'Seven Stages in The Believer’s Spiritual Development.pptx',
                'count' => 168,
            ],
            [
                'name' => 'Seven Stages in The Believer’s Spiritual Development.pdf',
                'count' => 237,
            ],
            [
                'name' => '7 Stages of Spiritual Development.mp3',
                'count' => 318,
            ],
            [
                'name' => 'Psalm 23 How God Deals With Hurting Sheep.pdf',
                'count' => 154,
            ],
            [
                'name' => 'What The Bible Teaches About The Control of  Our Lives.pptx',
                'count' => 226,
            ],
            [
                'name' => 'What The Bible Teaches About The Control of  Our Lives.pdf',
                'count' => 217,
            ],
            [
                'name' => 'The Bible On Control Of Ones Live.mp3',
                'count' => 301,
            ],
            [
                'name' => 'Romans Introduction.pptx',
                'count' => 2494,
            ],
            [
                'name' => 'Romans Introduction.pdf',
                'count' => 138,
            ],
            [
                'name' => 'Romans Introduction.mp3',
                'count' => 220,
            ],
            [
                'name' => 'Romans 1 1-17 Introduction to the Gospel Messgage of Romans.pptx',
                'count' => 138,
            ],
            [
                'name' => 'Romans 1 1-17 Introduction to the Gospel Messgage of Romans.pdf',
                'count' => 104,
            ],
            [
                'name' => 'Romans 1 1-17.mp3',
                'count' => 294,
            ],
            [
                'name' => 'Romans 1 18-32.pptx',
                'count' => 164,
            ],
            [
                'name' => 'Romans 1 18-32.pdf',
                'count' => 166,
            ],
            [
                'name' => 'Romans 1 18-32.mp3',
                'count' => 345,
            ],
            [
                'name' => 'Intelligent Design - Walter Myers II.mp3',
                'count' => 495,
            ],
            [
                'name' => 'Intelligent Design.pdf',
                'count' => 403,
            ],
            [
                'name' => 'Romans 2 1-16 The Hypocritical Moralist on Trial.pptx',
                'count' => 169,
            ],
            [
                'name' => 'Romans 2 1-16 The Hypocritical Moralist on Trial.pdf',
                'count' => 127,
            ],
            [
                'name' => 'Romans 2 1-16.mp3',
                'count' => 213,
            ],
            [
                'name' => 'Romans 2 17-29.pptx',
                'count' => 180,
            ],
            [
                'name' => 'Romans 2 17-29.pdf',
                'count' => 155,
            ],
            [
                'name' => 'Romans 2 17-29.mp3',
                'count' => 251,
            ],
            [
                'name' => 'Hell - The Theological Hot Potato of the Christian Faith.pptx',
                'count' => 297,
            ],
            [
                'name' => 'Hell - The Theological Hot Potato of the Christian Faith.pdf',
                'count' => 293,
            ],
            [
                'name' => 'Hell - The Hot Potato of the Christian Faith.mp3',
                'count' => 453,
            ],
            [
                'name' => 'Romans 3 1-20 Mans True Nature Exposed and Filleted .pptx',
                'count' => 162,
            ],
            [
                'name' => 'Romans 3 1-20 Mans True Nature Exposed and Filleted .pdf',
                'count' => 152,
            ],
            [
                'name' => 'Romans 3 1-20.mp3',
                'count' => 369,
            ],
            [
                'name' => 'God and Evil.pptx',
                'count' => 342,
            ],
            [
                'name' => 'God and Evil .pdf',
                'count' => 349,
            ],
            [
                'name' => 'God and Evil.mp3',
                'count' => 368,
            ],
            [
                'name' => 'Homosexuality and Same - Sex Marriage.pdf',
                'count' => 359,
            ],
            [
                'name' => 'Homosexuality and Same-Sex Marriage.mp3',
                'count' => 449,
            ],
            [
                'name' => 'Can we trust the new testament.ppt',
                'count' => 332,
            ],
            [
                'name' => 'Can we trust the new testament.pdf',
                'count' => 357,
            ],
            [
                'name' => 'Can We Trust the New Testament.mp3',
                'count' => 464,
            ],
            [
                'name' => 'God’s Story of My Life .pptx',
                'count' => 351,
            ],
            [
                'name' => 'God’s Story of My Life .pdf',
                'count' => 234,
            ],
            [
                'name' => 'God Made The Story of My Life.mp3',
                'count' => 404,
            ],
            [
                'name' => 'Christianity in a World of Religions.mp3',
                'count' => 389,
            ],
            [
                'name' => 'Christianity in a World of Religions.pdf',
                'count' => 287,
            ],
            [
                'name' => 'Romans  3 21-4 25 Introduction to the Salvation Section of Romans.pptx',
                'count' => 1996,
            ],
            [
                'name' => 'Romans  3 21-4 25 Introduction to the Salvation Section of Romans.pdf',
                'count' => 149,
            ],
            [
                'name' => 'Romans 3 21-4 25 - Introduction to the Salvation Section of Romans.mp3',
                'count' => 351,
            ],
            [
                'name' => 'Justification by Faith Alone  Martin Luther and Romans 1 17.avi',
                'count' => 181,
            ],
            [
                'name' => 'Martin Luther - By Faith Alone In Christ Alone.avi',
                'count' => 254,
            ],
            [
                'name' => 'Justification - Second introduction to Romans 3 21-4 25.pptx',
                'count' => 226,
            ],
            [
                'name' => 'Justification -Second introduction to Romans 3 21-4 25.pdf',
                'count' => 162,
            ],
            [
                'name' => 'Justification Intro Rom 3 21-4 25.mp3',
                'count' => 423,
            ],
            [
                'name' => 'Why I Hate Religion But Love Jesus - Muslim Version Spoken Word    Response.avi',
                'count' => 201,
            ],
            [
                'name' => 'Why I Hate Religion But Love Jesus - One Atheists Spoken Word Response.avi',
                'count' => 231,
            ],
            [
                'name' => 'Why I Love Religion And Love Jesus - Catholic Response    Spoken Word.avi',
                'count' => 193,
            ],
            [
                'name' => 'Why I Hate Religion But Love Jesus  Spoken Word.avi',
                'count' => 1578,
            ],
            [
                'name' => 'The Romans salvation message in four  minutes - Third introduction to Romans 3 21-28.pptx',
                'count' => 320,
            ],
            [
                'name' => 'The Romans salvation message in four minutes - Third introduction to Romans 3 21-28.pdf',
                'count' => 181,
            ],
            [
                'name' => 'Introduction 3 - The Gospel in 4 min.mp3',
                'count' => 430,
            ],
            [
                'name' => 'Introduction 4 - Eight reasons why being a good person is not a ticket to heaven.pdf',
                'count' => 210,
            ],
            [
                'name' => 'Introduction 4 - Eight reasons why being a good person is not a ticket to heaven.pptx',
                'count' => 256,
            ],
            [
                'name' => 'Introduction 4 - Eight reasons why being a good person is not a ticket to heaven.mp3',
                'count' => 372,
            ],
            [
                'name' => 'Romans 3 21-31 The Core of Romans Salvation Message.pptx',
                'count' => 227,
            ],
            [
                'name' => 'Romans 3 21-31 The Core of Romans Salvation Message.pdf',
                'count' => 171,
            ],
            [
                'name' => 'Romans 3 21-31.mp3',
                'count' => 341,
            ],
            [
                'name' => 'Romans 4 Abraham as proof of justification by faith.pptx',
                'count' => 217,
            ],
            [
                'name' => 'Romans 4 Abraham as proof of justification by faith.pdf',
                'count' => 168,
            ],
            [
                'name' => 'Rom 4 Abraham proof of justification.mp3',
                'count' => 327,
            ],
            [
                'name' => 'Into to Romans 5 Comparison Between Protestantism and Catholicism on Justification - Part  1.pptx',
                'count' => 353,
            ],
            [
                'name' => 'Into to Romans 5 Comparison Between Protestantism and Catholicism on Justification - Part  1.pdf',
                'count' => 145,
            ],
            [
                'name' => 'Comparison between Protestantism and.mp3',
                'count' => 344,
            ],
            [
                'name' => 'Into to Romans 5  Comparison Between Protestantism and Catholicism on Justification - Part  2.pptx',
                'count' => 421,
            ],
            [
                'name' => 'Into to Romans 5  Comparison Between Protestantism and Catholicism on Justification - Part  2.pdf',
                'count' => 205,
            ],
            [
                'name' => 'Catholic and Protestant on Justification2.mp3',
                'count' => 413,
            ],
            [
                'name' => 'Into to Romans 5  Comparison Between Protestantism and Catholicism on Justification - Part  3.pptx',
                'count' => 214,
            ],
            [
                'name' => 'Into to Romans 5  Comparison Between Protestantism and Catholicism on Justification - Part  3.pdf',
                'count' => 170,
            ],
            [
                'name' => 'Are Future Sins Forgiven at Salvatio.mp3',
                'count' => 497,
            ],
            [
                'name' => 'Romans 5 1-11 The Blessings that Flow from Justification.pptx',
                'count' => 261,
            ],
            [
                'name' => 'Romans 5 1-11 The blessings that Flow from justification.pdf',
                'count' => 165,
            ],
            [
                'name' => 'Romans 5 1-11 Blessings that flow fr.mp3',
                'count' => 371,
            ],
            [
                'name' => 'Romans 5 12-21.mp3',
                'count' => 331,
            ],
            [
                'name' => 'Romans 5 12-21 The One Passage That Explains It All.pdf',
                'count' => 154,
            ],
            [
                'name' => 'Romans 5 12-21 The One Passage That Explains It All.pptx',
                'count' => 196,
            ],
            [
                'name' => 'Enslaved to God Intro Rom 6-8.mp3',
                'count' => 387,
            ],
            [
                'name' => 'Introduction to Romans 6-8 Enslaved to God.pdf',
                'count' => 323,
            ],
            [
                'name' => 'Introduction to Romans 6-8 Enslaved to God.pptx',
                'count' => 204,
            ],
            [
                'name' => 'Intro Rom 6-8 - One Passage That Tells it all - Part 1.mp3',
                'count' => 262,
            ],
            [
                'name' => 'Intro to Romans 6 - Sin the Destroyer of Everything - Part 1.pptx',
                'count' => 138,
            ],
            [
                'name' => 'Intro to Romans 6 - Sin the Destroyer of Everything - Part 1.pdf',
                'count' => 135,
            ],
            [
                'name' => 'Romans 6 12-23 Why The Believer Does Not Have To Sin Anymore.pptx',
                'count' => 157,
            ],
            [
                'name' => 'Romans 6 12-23 Why The Believer Does Not Have To Sin Anymore.pdf',
                'count' => 148,
            ],
            [
                'name' => 'Ro 6 12-23 Why The Believer Does Not Have To Sin.mp3',
                'count' => 254,
            ],
            [
                'name' => 'Intro Rom 6-8 - One Passage That Tells it all - Part 2.mp3',
                'count' => 261,
            ],
            [
                'name' => 'Intro to Romans 6 - Sin the Destroyer of Everything - Part 2.pdf',
                'count' => 137,
            ],
            [
                'name' => 'Intro to Romans 6 - Sin the Destroyer of Everything - Part 2.pptx',
                'count' => 141,
            ],
            [
                'name' => 'Romans 6 1-11 Dead Man Walking - The Key to Sanctification.pdf',
                'count' => 144,
            ],
            [
                'name' => 'Romans 6 1-11 Dead Man Walking - The Key to Sanctification.pptx',
                'count' => 334,
            ],
            [
                'name' => 'Dead Man Walking Rom 6 1-11.mp3',
                'count' => 246,
            ],
            [
                'name' => 'Introduction to Romans 7 - The Four Shouts of Antinomianism.pptx',
                'count' => 160,
            ],
            [
                'name' => 'Introduction to Romans 7 - The Four Shouts of Antinomianism.pdf',
                'count' => 144,
            ],
            [
                'name' => 'Intro to Romans 7 - The Four Shouts of Antinomianism.mp3',
                'count' => 144,
            ],
            [
                'name' => 'Romans 7 1-13 Dead to the Law.pptx',
                'count' => 161,
            ],
            [
                'name' => 'Romans 7 1-13 Dead to the Law.pdf',
                'count' => 163,
            ],
            [
                'name' => 'Rom 7 1-13 Dead to the Law.mp3',
                'count' => 157,
            ],
            [
                'name' => 'Romans 7 14-25 - The Greatest Battle of Your Life.pptx',
                'count' => 172,
            ],
            [
                'name' => 'Romans 7 14-25 - The Greatest Battle of Your Life.pdf',
                'count' => 151,
            ],
            [
                'name' => 'Ro 7 14-25 -The Battle of Your Life.mp3',
                'count' => 155,
            ],
            [
                'name' => 'Religious Pluralism.pptx',
                'count' => 231,
            ],
            [
                'name' => 'Religious Pluralism.pdf',
                'count' => 239,
            ],
            [
                'name' => 'Religious Pluralism.mp3',
                'count' => 167,
            ],
            [
                'name' => 'Not So New Atheism.pdf',
                'count' => 222,
            ],
            [
                'name' => 'Not So New Atheism.mp3',
                'count' => 167,
            ],
            [
                'name' => 'Jehovahs Witnesses Presentation.pptx',
                'count' => 290,
            ],
            [
                'name' => 'Jehovahs Witnesses Presentation.pdf',
                'count' => 281,
            ],
            [
                'name' => 'Jehovahs Witnesses Presentation.mp3',
                'count' => 141,
            ],
            [
                'name' => 'Mormonism Presentation .mp3',
                'count' => 155,
            ],
            [
                'name' => 'Islam.mp3',
                'count' => 137,
            ],
            [
                'name' => 'Romans 7 and Addictions.mp3',
                'count' => 155,
            ],
            [
                'name' => 'Same-Sex Marriage and Religious Freedom.pdf',
                'count' => 150,
            ],
            [
                'name' => 'Part 1 Intro to Romans 8 and Why  it is the Greatest Chapter in the Bible.pptx',
                'count' => 141,
            ],
            [
                'name' => 'Part 1 Intro to Romans 8 and Why  it is the Greatest Chapter in the Bible.pdf',
                'count' => 179,
            ],
            [
                'name' => 'Rom 8 Intro 1 - Greatest Chapter.mp3',
                'count' => 162,
            ],
            [
                'name' => 'Part 2 Intro to Romans 8 - 29 Salvational Blessings.pptx',
                'count' => 174,
            ],
            [
                'name' => 'Part 2 Intro to Romans 8 - 29 Salvational Blessings.pdf',
                'count' => 209,
            ],
            [
                'name' => 'Rom 8 Intro 2 - Greatest Chapter.mp3',
                'count' => 163,
            ],
            [
                'name' => 'Rom 8 1-4 condemnation Free.mp3',
                'count' => 164,
            ],
            [
                'name' => 'Romans 8.1-4 Condemnation Free in Christ.pdf',
                'count' => 161,
            ],
            [
                'name' => 'Romans 8.1-4 Condemnation Free in Christ.pptx',
                'count' => 220,
            ],
            [
                'name' => 'Romans 8 5-17 - The Tale of Two Men Who Represent All - Part 1.pptx',
                'count' => 163,
            ],
            [
                'name' => 'Romans 8 5-17 - The Tale of Two Men Who Represent All - Part 1.pdf',
                'count' => 149,
            ],
            [
                'name' => 'Rom 8 5-17 Tale of Two Men Part 1.mp3',
                'count' => 160,
            ],
            [
                'name' => 'The Unworthy Comparison of Romans 8 18.pptx',
                'count' => 162,
            ],
            [
                'name' => 'The Unworthy Comparison of Romans 8 18.pdf',
                'count' => 159,
            ],
            [
                'name' => 'Romans 8 18 An Unworthy Comparison.mp3',
                'count' => 160,
            ],
            [
                'name' => 'Romans 8 5-17 - The Tale of Two Men - Part 2.pdf',
                'count' => 157,
            ],
            [
                'name' => 'Romans 8 5-17 - The Tale of Two Men - Part 2.pptx',
                'count' => 177,
            ],
            [
                'name' => 'Rom 8 5-17 The Tale of Two Men Part 2.mp3',
                'count' => 155,
            ],
            [
                'name' => 'Miracles and the Miraculous.mp3',
                'count' => 140,
            ],
            [
                'name' => 'Abraham - Faith in the Face of Suffering.mp3',
                'count' => 137,
            ],
            [
                'name' => 'Helping someone who is going through suffering.pptx',
                'count' => 130,
            ],
            [
                'name' => 'Helping someone who is going through suffering.pdf',
                'count' => 124,
            ],
            [
                'name' => 'Helping someone who is going through.mp3',
                'count' => 134,
            ],
            [
                'name' => 'Romans 8 19-22 - The Curse of Earth Reversed.pptx',
                'count' => 169,
            ],
            [
                'name' => 'Romans 8 19-22 - The Curse of Earth Reversed.pdf',
                'count' => 160,
            ],
            [
                'name' => 'Rom 8 19-22 The Curse of Earth Reversed.mp3',
                'count' => 147,
            ],
            [
                'name' => 'Rom 8 23 The Plan of God for Aging.mp3',
                'count' => 136,
            ],
            [
                'name' => 'Romans 8 23 - The Solution of God to the Aging Problem.pptx',
                'count' => 176,
            ],
            [
                'name' => 'Romans 8 23 - The Solution of God to the Aging Problem.pdf',
                'count' => 152,
            ],
            [
                'name' => 'Romans 8 24-25 - Faith Connected  at the Hip to Hope.pptx',
                'count' => 146,
            ],
            [
                'name' => 'Romans 8 24-25 - Faith Connected  at the Hip to Hope.pdf',
                'count' => 148,
            ],
            [
                'name' => 'Romans 8 24-25 - Faith Connected  at the Hip to Hope.mp3',
                'count' => 128,
            ],
            [
                'name' => 'Romans 8 24-25 - Ten Top Verses on Hope - Part 2.pptx',
                'count' => 144,
            ],
            [
                'name' => 'Romans 8 24-25 - Ten Top Verses on Hope - Part 2.pdf',
                'count' => 149,
            ],
            [
                'name' => 'Romans 8 24-25 Ten Top Verses on Hope.mp3',
                'count' => 142,
            ],
            [
                'name' => 'Seven Considerations as Christians Cope with the Unchristianing  of America.pptx',
                'count' => 171,
            ],
            [
                'name' => 'Seven Considerations as Christians Cope with the Unchristianing  of Amer....pdf',
                'count' => 133,
            ],
            [
                'name' => '7 Considerations re America.mp3',
                'count' => 159,
            ],
            [
                'name' => 'The Work of the Holy Trinity in Romans 8.pptx',
                'count' => 197,
            ],
            [
                'name' => 'The Work of the Holy Trinity in Romans 8.pdf',
                'count' => 154,
            ],
            [
                'name' => 'The Work of the Holy Trinity in Romans 8.mp3',
                'count' => 149,
            ],
            [
                'name' => 'How the Spirit Strengthens our Weak Prayers.pptx',
                'count' => 163,
            ],
            [
                'name' => 'How the Spirit Strengthens our Weak Prayers.pdf',
                'count' => 157,
            ],
            [
                'name' => 'How the Spirit Strengthens our Weak Prayers.mp3',
                'count' => 149,
            ],
            [
                'name' => 'Romans 8 28 The Promise of God to Shape Every Detail of My Life for Good.pptx',
                'count' => 146,
            ],
            [
                'name' => 'Romans 8 28 The Promise of God to Shape Every Detail of My Life for Good.pdf',
                'count' => 154,
            ],
            [
                'name' => 'Romans 8 28 The Promise of God to Shape Every Detail of My Life for Good.mp3',
                'count' => 154,
            ],
            [
                'name' => 'Romans 8 29-30 - The Third Choice Between Predestination and Free Will.pptx',
                'count' => 142,
            ],
            [
                'name' => 'Romans 8 29-30 - The Third Choice Between Predestination and Free Will.pdf',
                'count' => 125,
            ],
            [
                'name' => 'Romans 8 29-30 - The Third Choice Between Predestination and Free Will.mp3',
                'count' => 136,
            ],
            [
                'name' => 'Romans 8 31-34 - Grasping the wonderful truth that God is for me.pdf',
                'count' => 119,
            ],
            [
                'name' => 'Romans 8 31-34 - Grasping the wonderful truth that God is for me.pptx',
                'count' => 121,
            ],
            [
                'name' => 'Romans 8 31-34 - Grasping the wonderful truth that God is for me.mp3',
                'count' => 131,
            ],
            [
                'name' => 'Romans 8 - 35-39 The Greatest Passage in all the Bible on God\'s Love - Part 1.pdf',
                'count' => 98,
            ],
            [
                'name' => 'Romans 8 35-39 The Greatest Passage in all the Bible on God\'s Love - Part 1.mp3',
                'count' => 96,
            ],
            [
                'name' => 'Romans 8 - 35-39  The Greatest Passage in all the Bible on God\'s Love - Part 1.pptx',
                'count' => 0,
            ],
            [
                'name' => 'Romans 8 - 35-39 The Greatest Passage in all the Bible on God\'s Love - Part 2.pptx',
                'count' => 97,
            ],
            [
                'name' => 'Romans 8 - 35-39 The Greatest Passage in all the Bible on God\'s Love - Part 2.pdf',
                'count' => 91,
            ],
            [
                'name' => 'Romans 8 - 35-39 The Greatest Passage in all the Bible on God\'s Love - Part 2.mp3',
                'count' => 101,
            ],
            [
                'name' => 'Five lessons regarding love and compassion from the parable of the Good Samaritan – Luke 10 25-37.pptx',
                'count' => 85,
            ],
            [
                'name' => 'Five lessons regarding love and compassion from the parable of the Good Samaritan – Luke 10 25-37.pdf',
                'count' => 70,
            ],
            [
                'name' => 'Five lessons regarding love and compassion from the parable of the Good Samaritan  Luke 10 25-37.mp3',
                'count' => 89,
            ],
            [
                'name' => 'Your Need for Seven Spiritual Qualities that Jesus Commended - Part 1.docx.pptx',
                'count' => 69,
            ],
            [
                'name' => 'Your Need for Seven Spiritual Qualities that Jesus Commended - Part 1.docx.pdf',
                'count' => 79,
            ],
            [
                'name' => 'Your Need for Seven Spiritual Qualities that Jesus Commended - Part 1.mp3',
                'count' => 90,
            ],
            [
                'name' => 'Your Need for Seven Spiritual Qualities that Jesus Commended - Part 2.pptx',
                'count' => 75,
            ],
            [
                'name' => 'Your Need for Seven Spiritual Qualities that Jesus Commended - Part 2.pdf',
                'count' => 69,
            ],
            [
                'name' => 'Your Need for Seven Spiritual Qualities that Jesus Commended - Part 2.mp3',
                'count' => 89,
            ],
            [
                'name' => 'A Biblical Pathway for Dealing with Difficult People - Part 1.pptx',
                'count' => 61,
            ],
            [
                'name' => 'A Biblical Pathway for Dealing with Difficult People - Part 1.pdf',
                'count' => 67,
            ],
            [
                'name' => 'A Biblical Pathway for Dealing with Difficult People - Part 1.mp3',
                'count' => 89,
            ],
            [
                'name' => 'A Biblical Pathway for Dealing with Difficult People - Part 2.pptx',
                'count' => 61,
            ],
            [
                'name' => 'A Biblical Pathway for Dealing with Difficult People - Part 2.pdf',
                'count' => 71,
            ],
            [
                'name' => 'A Biblical Pathway for Dealing with Difficult People - Part 2.mp3',
                'count' => 93,
            ],
            [
                'name' => 'Intro to Romans 9-11  - Part 1.pptx',
                'count' => 57,
            ],
            [
                'name' => 'Intro to Romans 9-11  - Part 1.pdf',
                'count' => 62,
            ],
            [
                'name' => 'Intro to Romans 9-11  - Part 1.mp3',
                'count' => 90,
            ],
            [
                'name' => 'Intro to Romans 9-11  The Prophecies and fullfillment of Jesus regarding the Church - Part 2.pptx',
                'count' => 81,
            ],
            [
                'name' => 'Intro to Romans 9-11  The Prophecies and fullfillment of Jesus regarding the Church - Part 2.pdf',
                'count' => 77,
            ],
            [
                'name' => 'Intro to Romans 9-11  The Prophecies and fullfillment of Jesus regarding the Church - Part 2.mp3',
                'count' => 88,
            ],
            [
                'name' => 'Intro to Romans 9-11  How AD 70 Jewish Exile is Evidence of Christianity\'s Authenticity - Part 3.pptx',
                'count' => 63,
            ],
            [
                'name' => 'Intro to Romans 9-11  How AD 70 Jewish Exile is Evidence of Christianity\'s Authenticity - Part 3.pdf',
                'count' => 66,
            ],
            [
                'name' => 'Intro to Romans 9-11  How AD 70 Jewish Exile is Evidence of Christianity\'s Authenticity - Part 3.mp3',
                'count' => 56,
            ],
            [
                'name' => 'Intro to Romans 9-11 - Part 4 Father Abraham and his many sons - A study in true salvational faith.pptx',
                'count' => 86,
            ],
            [
                'name' => 'Intro to Romans 9-11 - Part 4 Father Abraham and his many sons - A study in true salvational faith.pdf',
                'count' => 74,
            ],
            [
                'name' => 'Intro to Romans 9-11 - Part 4 Father Abraham and his many sons - A study in true salvational faith.mp3',
                'count' => 91,
            ],
            [
                'name' => 'Romans 9 1-5 - Paul’s Grieving Heart Over Israel’s Rejection of Her Messiah.pptx',
                'count' => 79,
            ],
            [
                'name' => 'Romans 9 1-5 - Paul’s Grieving Heart Over Israel’s Rejection of Her Messiah.pdf',
                'count' => 90,
            ],
            [
                'name' => 'The Mystery of the Jews.mp4',
                'count' => 81,
            ],
            [
                'name' => 'Romans 9.1-5 - Pauls Grieving Heart Over Israel’s Rejection of Her Messiah.mp3',
                'count' => 132,
            ],
            [
                'name' => 'How the Plan of God in Regards to Israel Was Not a Divine Slipup - Romans 9 6-13.pptx',
                'count' => 66,
            ],
            [
                'name' => 'How the Plan of God in Regards to Israel Was Not a Divine Slipup - Romans 9 6-13.pdf',
                'count' => 75,
            ],
            [
                'name' => 'How the Plan of God in Regards to Israel Was Not a Divine Slipup - Romans 9 6-13.mp3',
                'count' => 93,
            ],
            [
                'name' => 'Romans 9  14-18 - The Wooing and Hardening of God in Salvation.pptx',
                'count' => 71,
            ],
            [
                'name' => 'Romans 9  14-18 - The Wooing and Hardening of God in Salvation.pdf',
                'count' => 66,
            ],
            [
                'name' => 'Romans 9  14-18 - The Wooing and Hardening of God in Salvation.mp3',
                'count' => 92,
            ],
            [
                'name' => 'God is God and You Are Not - Romans 9  19-24.pptx',
                'count' => 64,
            ],
            [
                'name' => 'God is God and You Are Not - Romans 9  19-24.pdf',
                'count' => 71,
            ],
            [
                'name' => 'God is God and You Are Not - Romans 9  19-24.mp3',
                'count' => 94,
            ],
            [
                'name' => 'John MacArthur Predestination question from 2010 Shepherd\'s Conference.mp4',
                'count' => 66,
            ],
            [
                'name' => 'Thinking through whether people should have children in a messed up world.pptx',
                'count' => 56,
            ],
            [
                'name' => 'Thinking through whether people should have children in a messed up world.pdf',
                'count' => 64,
            ],
            [
                'name' => 'Rocky Balboa best inspirational speech ever [Subtitles], - YouTube.flv.mp4',
                'count' => 61,
            ],
            [
                'name' => 'Thinking through whether people should have children in a messed up world.mp3',
                'count' => 79,
            ],
            [
                'name' => 'Being the Father of a Prodigal - Luke 15 11-32.pptx',
                'count' => 61,
            ],
            [
                'name' => 'Being the Father of a Prodigal - Luke 15 11-32.pdf',
                'count' => 61,
            ],
            [
                'name' => 'Being the Father of a Prodigal - Luke 15 11-32.mp3',
                'count' => 80,
            ],
            [
                'name' => 'Shocking Oscars Mix-Up׃ Moonlight Wins Best Picture Over La La Land.mp4',
                'count' => 60,
            ],
            [
                'name' => 'How to Die with a Satisfied Life.pptx',
                'count' => 61,
            ],
            [
                'name' => 'How to Die with a Satisfied Life.pdf',
                'count' => 58,
            ],
            [
                'name' => 'How to Die With a Satisfied Life.mp3',
                'count' => 93,
            ],
            [
                'name' => 'How Jesus Used Questions Effectively and How You can Too.pptx',
                'count' => 50,
            ],
            [
                'name' => 'How Jesus Used Questions Effectively and How You can Too.pdf',
                'count' => 60,
            ],
            [
                'name' => 'How Jesus Used Questions Effectively and How You can Too.mp3',
                'count' => 60,
            ],
            [
                'name' => 'Romans 9 1-5 - Pauls Grieving Heart Over Israel’s Rejection of Her Messiah.mp3',
                'count' => 65,
            ],
            [
                'name' => 'Romans 9 25-33 Boiling Down to the Core Difference Between True and False Religion.pptx',
                'count' => 52,
            ],
            [
                'name' => 'Romans 9 25-33 Boiling Down to the Core Difference Between True and False Religion.pdf',
                'count' => 60,
            ],
            [
                'name' => 'Romans 10 1-11 Dealing with the heartbreak over those you love rejecting the Lord.pdf',
                'count' => 60,
            ],
            [
                'name' => 'Romans 10 1-11 Dealing with the heartbreak of those you love rejecting the Lord.pptx',
                'count' => 57,
            ],
            [
                'name' => 'Romans 10 1-11 Dealing with the heartbreak of those you love rejecting the Lord.mp3',
                'count' => 71,
            ],
            [
                'name' => 'Romans 10 12-21 The Beautiful Feet of Those Who Love Enough to Share Their Faith.pptx',
                'count' => 60,
            ],
            [
                'name' => 'Romans 10 12-21 The Beautiful Feet of Those Who Love Enough to Share Their Faith.pdf',
                'count' => 58,
            ],
            [
                'name' => 'Romans 10 12-21 The Beautiful Feet of Those Who Love Enough to Share Their Faith.mp3',
                'count' => 76,
            ],
            [
                'name' => 'Evil in the Heart.pptx',
                'count' => 40,
            ],
            [
                'name' => 'Evil in the Heart.pdf',
                'count' => 43,
            ],
            [
                'name' => 'Evil in the Heart.mp3',
                'count' => 54,
            ],
            [
                'name' => 'John MacArthur on Charlottesville.mp4',
                'count' => 39,
            ],
            [
                'name' => 'Intro to Romans 11 - The Faithfulness of God to Israel Despite the Unfaithfulness of Israel to God.pptx',
                'count' => 37,
            ],
            [
                'name' => 'Intro to Romans 11 - The Faithfulness of God to Israel Despite the Unfaithfulness of Israel to God.pdf',
                'count' => 30,
            ],
            [
                'name' => 'Romans 11 - The Faithfulness of God to Israel Despite the Unfaithfulness of Israel to God.pptx',
                'count' => 43,
            ],
            [
                'name' => 'Romans 11 - The Faithfulness of God to Israel Despite the Unfaithfulness of Israel to God.pdf',
                'count' => 31,
            ],
            [
                'name' => 'Romans 11 - The Faithfulness of God to Israel Despite the Unfaithfulness of Israel to God.mp3',
                'count' => 46,
            ],
            [
                'name' => 'Introduction - The Design of God for Happiness and Six Enemies Which Keep You From It - Part 1.pptx',
                'count' => 17,
            ],
            [
                'name' => 'Introduction - The Design of God for Happiness and Six Enemies Which Keep You From It - Part 1.pdf',
                'count' => 18,
            ],
            [
                'name' => 'Introduction - The Design of God for Happiness and Six Enemies Which Keep You From It - Part 1.mp3',
                'count' => 25,
            ],
            [
                'name' => 'Introduction - The Design of God for Happiness and Six Enemies Which Keep You From It - Part 2.pptx',
                'count' => 17,
            ],
            [
                'name' => 'Introduction - The Design of God for Happiness and Six Enemies Which Keep You From It - Part 2.pdf',
                'count' => 14,
            ],
            [
                'name' => 'Introduction - The Design of God for Happiness and Six Enemies Which Keep You From It - Part 2.mp3',
                'count' => 22,
            ],
            [
                'name' => 'Enemy 1 - Meaninglessness.pptx',
                'count' => 13,
            ],
            [
                'name' => 'Enemy 1 - Meaninglessness.pdf',
                'count' => 11,
            ],
            [
                'name' => 'Enemy 1 of Happiness - Meaninglessne.mp3',
                'count' => 23,
            ],
            [
                'name' => 'Happiness Enemy 2 - iWorship.pptx',
                'count' => 16,
            ],
            [
                'name' => 'Happiness Enemy 2 - iWorship.pdf',
                'count' => 15,
            ],
            [
                'name' => 'Happiness Enemy 2 - iWorship.mp3',
                'count' => 18,
            ],
            [
                'name' => 'Enemy 3 - Unbridled Pleasure.pptx',
                'count' => 9,
            ],
            [
                'name' => 'Enemy 3 - Unbridled Pleasure.pdf',
                'count' => 9,
            ],
            [
                'name' => 'Enemy 3 - Unbridled Pleasure.mp3',
                'count' => 11,
            ],
            [
                'name' => 'Happiness Enemy 4 - Chicken Heartedness.pptx',
                'count' => 8,
            ],
            [
                'name' => 'Happiness Enemy 4 - Chicken Heartedness.pdf',
                'count' => 7,
            ],
            [
                'name' => 'Happiness Enemy 4 - Chicken Heartedness.mp3',
                'count' => 11,
            ],
            [
                'name' => 'Happiness Enemy 5 - Friendlessnes.pptx',
                'count' => 7,
            ],
            [
                'name' => 'Happiness Enemy 5 - Friendlessnes.pdf',
                'count' => 7,
            ],
            [
                'name' => 'Happiness Enemy 5 - Friendlessnes.mp3',
                'count' => 13,
            ],
            [
                'name' => 'Happiness Enemy 6 - Negativity.pptx',
                'count' => 6,
            ],
            [
                'name' => 'Happiness Enemy 6 - Negativity.mp3',
                'count' => 13,
            ],
            [
                'name' => 'Happiness Enemy 6 -  Negativity.pdf',
                'count' => 5,
            ]
        ];

        foreach ($att as $item) {
            OldAnalytics::create($item);
        }
    }
}
