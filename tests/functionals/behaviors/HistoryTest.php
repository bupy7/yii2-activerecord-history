<?php

namespace bupy7\activerecord\history\tests\functionals\behaviors;

use Yii;
use bupy7\activerecord\history\tests\functionals\TestCase;
use bupy7\activerecord\history\tests\functionals\assets\models\Post;
use bupy7\activerecord\history\tests\functionals\assets\models\User;
use yii\db\Query;
use bupy7\activerecord\history\behaviors\History;
use yii\db\Expression;
use DateTime;

class HistoryTest extends TestCase
{
    public function testInsertEventRecord()
    {
        $post = new Post();

        $post->attachBehavior('arhistory', [
            'class' => 'bupy7\activerecord\history\behaviors\History',
        ]);

        $post->title = 'New Post Title';
        $post->content = 'New Post Content';
        $post->type = Post::TYPE_NEWS;
        $post->created_at = (new DateTime())->format(Post::DATE_TIME_FORMAT);
        $post->updated_at = $post->created_at;

        $this->assertTrue($post->save());

        $q = new Query();
        $history = $q->from('arhistory')
            ->where(['row_id' => $post->id])
            ->one();

        $this->assertNotFalse($history);
        $this->assertEquals(1, $history['event']);
        $this->assertNull($history['field_name']);
        $this->assertNull($history['old_value']);
        $this->assertNull($history['new_value']);
        $this->assertEquals('{{%post}}', $history['table_name']);
        $this->assertEquals(100, $history['created_by']);
        $this->assertNotNull($history['created_at']);
    }


    public function testUpdateEventRecord()
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
        $this->assertFalse(isset($history['type']));
    }

    public function testDeleteEventRecord()
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

        $this->assertNotFalse($history);
        $this->assertEquals(3, $history['event']);
        $this->assertNull($history['field_name']);
        $this->assertNull($history['old_value']);
        $this->assertNull($history['new_value']);
        $this->assertEquals('{{%post}}', $history['table_name']);
        $this->assertEquals(100, $history['created_by']);
        $this->assertNotNull($history['created_at']);
    }

    public function testCustomAttributes()
    {
        $post = Post::findOne(1);

        $post->attachBehavior('arhistory', [
            'class' => 'bupy7\activerecord\history\behaviors\History',
            'customAttributes' => [
                'type' => function ($event, $isNewValue) {
                    if ($isNewValue) {
                        return Post::getTypes()[$event->sender->type];
                    }
                    return Post::getTypes()[$event->changedAttributes['type']];
                },
            ],
        ]);

        $post->title = 'Change Title';
        $post->type = Post::TYPE_ARTICLE;

        $this->assertTrue($post->save());

        $q = new Query();
        $history = $q->from('arhistory')
            ->where(['row_id' => $post->id])
            ->indexBy('field_name')
            ->all();

        $this->assertCount(2, $history);
        $this->assertEquals('Change Title', $history['title']['new_value']);
        $this->assertEquals('News', $history['type']['old_value']);
        $this->assertEquals('Article', $history['type']['new_value']);
    }

    public function testSkipAttributes()
    {
        $post = Post::findOne(1);

        $post->attachBehavior('arhistory', [
            'class' => 'bupy7\activerecord\history\behaviors\History',
            'skipAttributes' => [
                'type',
            ],
        ]);

        $post->title = 'Change Title';
        $post->type = Post::TYPE_ARTICLE;

        $this->assertTrue($post->save());

        $q = new Query();
        $history = $q->from('arhistory')
            ->where(['row_id' => $post->id])
            ->indexBy('field_name')
            ->all();

        $this->assertEquals('Change Title', $history['title']['new_value']);
        $this->assertFalse(isset($history['type']));
    }

    public function testIgnoreInsertEvent()
    {
        // insert
        $post = new Post();

        $post->attachBehavior('arhistory', [
            'class' => 'bupy7\activerecord\history\behaviors\History',
            'allowEvents' => [
                History::EVENT_UPDATE,
                History::EVENT_DELETE,
            ],
        ]);

        $post->title = 'New Post Title';
        $post->content = 'New Post Content';
        $post->type = Post::TYPE_NEWS;
        $post->created_at = (new DateTime())->format(Post::DATE_TIME_FORMAT);

        $this->assertTrue($post->save());

        $q = new Query();
        $history = $q->from('arhistory')
            ->where(['row_id' => $post->id])
            ->one();

        $this->assertFalse($history);
    }

    public function testIgnoreUpdateEvent()
    {
        $post = Post::findOne(1);

        $post->attachBehavior('arhistory', [
            'class' => 'bupy7\activerecord\history\behaviors\History',
            'allowEvents' => [
                History::EVENT_INSERT,
                History::EVENT_DELETE,
            ],
        ]);

        $post->title = 'Change Title';

        $this->assertTrue($post->save());

        $q = new Query();
        $history = $q->from('arhistory')
            ->where(['row_id' => $post->id])
            ->indexBy('field_name')
            ->all();

        $this->assertCount(0, $history);
    }

    public function testIgnoreDeleteEvent()
    {
        $post = Post::findOne(1);

        $post->attachBehavior('arhistory', [
            'class' => 'bupy7\activerecord\history\behaviors\History',
            'allowEvents' => [
                History::EVENT_INSERT,
                History::EVENT_UPDATE,
            ],
        ]);

        $this->assertGreaterThan(0, $post->delete());

        $q = new Query();
        $history = $q->from('arhistory')
            ->where(['row_id' => $post->id])
            ->one();

        $this->assertFalse($history);
    }

    public function testSkipAttributesWithDbExpression()
    {
        // test 1
        $post = Post::findOne(2);

        $post->attachBehavior('arhistory', [
            'class' => 'bupy7\activerecord\history\behaviors\History',
            'skipAttributes' => [
                'updated_at',
            ],
        ]);

        $post->title = 'Changed Title for Skip Attributes With Db Expression';
        $post->updated_at = new Expression('NOW()');

        $this->assertTrue($post->save());

        $q = new Query();
        $history = $q->from('arhistory')
            ->where(['row_id' => $post->id])
            ->indexBy('field_name')
            ->all();

        $this->assertFalse(isset($history['updated_at']));

        // test 2
        $post->updated_at = new Expression('NOW()');

        $this->assertTrue($post->save());

        $q = new Query();
        $history = $q->from('arhistory')
            ->where(['row_id' => $post->id])
            ->indexBy('field_name')
            ->all();

        $this->assertFalse(isset($history['updated_at']));

        // test 3
        $post->getBehavior('arhistory')->skipAttributes = [];

        $post->updated_at = new Expression('NOW()');

        $this->assertTrue($post->save());

        $q = new Query();
        $history = $q->from('arhistory')
            ->where(['row_id' => $post->id])
            ->indexBy('field_name')
            ->all();

        $this->assertTrue(isset($history['updated_at']));
    }

    protected function setUp()
    {
        parent::setUp();

        Yii::$app->user->login(User::findIdentity(100));
    }
}
