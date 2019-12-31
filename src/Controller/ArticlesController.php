<?php


namespace App\Controller;


class ArticlesController extends AppController
{
    public function index(){
        $this->loadComponent('Paginator');
        $articles = $this->Paginator->paginate($this->Articles->find());
        $this->set(compact('articles'));
    }

    public function view($slug = null){
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        $this->set(compact('article'));
    }

    public function add(){
        $article = $this->Articles->newEmptyEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());

            $article->user_id = 1;

            if ($this->Articles->save($article)){
                $this->Flash->success(__('Your article saved '));
                $this->redirect([ 'action' => 'index' ]);
            }
            $this->Flash->error(__('Error occured'));
        }
        $this->set('article', $article);
    }
}
