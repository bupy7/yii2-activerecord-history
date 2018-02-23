<?php

namespace bupy7\activerecord\history\tests\functionals\behaviors;

use Yii;
use bupy7\activerecord\history\tests\functionals\TestCase;
use bupy7\activerecord\history\tests\functionals\assets\models\Post;
use bupy7\activerecord\history\tests\functionals\assets\models\User;
use yii\db\Query;

class HistoryTest extends TestCase
{
    public function testCreateNewRecord()
    {
        $post = new Post();

        $post->attachBehavior('arhistory', [
            'class' => 'bupy7\activerecord\history\behaviors\History',
        ]);

        $post->title = 'New Post Title';
        $post->content = 'New Post Content';

        $this->assertTrue($post->save());

        $q = new Query();
        $history = $q->from('arhistory')
            ->where(['row_id' => $post->id])
            ->one();

        $this->assertNotNull($history);
        $this->assertEquals(1, $history['event']);
        $this->assertNull($history['field_name']);
        $this->assertNull($history['old_value']);
        $this->assertNull($history['new_value']);
        $this->assertEquals('{{%post}}', $history['table_name']);
        $this->assertEquals(100, $history['created_by']);
        $this->assertNotNull($history['created_at']);
    }


    public function testUpdateRecord()
    {
        $post = Post::findOne(1);

        $post->attachBehavior('arhistory', [
            'class' => 'bupy7\activerecord\history\behaviors\History',
        ]);

        $post->title = 'Change Title';
        $post->content = 'Change Content';

        $this->assertTrue($post->save());

        $q = new Query();
        $history = $q->from('arhistory')
            ->where(['row_id' => $post->id])
            ->indexBy('field_name')
            ->all();

        $this->assertCount(2, $history);
        $this->assertEquals(2, $history['title']['event']);
        $this->assertEquals('Example Title 1', $history['title']['old_value']);
        $this->assertEquals('Change Title', $history['title']['new_value']);
        $this->assertEquals(2, $history['content']['event']);
        $this->assertEquals('Example Content 1', $history['content']['old_value']);
        $this->assertEquals('Change Content', $history['content']['new_value']);
    }

    public function testDeleteRecord()
    {
        $post = Post::findOne(1);

        $post->attachBehavior('arhistory', [
            'class' => 'bupy7\activerecord\history\behaviors\History',
        ]);

        $this->assertGreaterThan(0, $post->delete());

        $q = new Query();
        $history = $q->from('arhistory')
            ->where(['row_id' => $post->id])
            ->one();

        $this->assertNotNull($history);
        $this->assertEquals(3, $history['event']);
        $this->assertNull($history['field_name']);
        $this->assertNull($history['old_value']);
        $this->assertNull($history['new_value']);
        $this->assertEquals('{{%post}}', $history['table_name']);
        $this->assertEquals(100, $history['created_by']);
        $this->assertNotNull($history['created_at']);
    }

    protected function setUp()
    {
        parent::setUp();

        Yii::$app->user->login(User::findIdentity(100));
    }
}
