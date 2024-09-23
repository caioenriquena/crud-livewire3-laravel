<?php

namespace App\Livewire;

use App\Livewire\Forms\PostForm;
use App\Models\Post;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class PostComponent extends Component
{
    use WithPagination;
//    #[Rule('required|min:3')]
//    public $title;
//
//    #[Rule('required|min:3')]
//    public $body;
    public PostForm $form;
    public $isOpen = 0;
    public $postId;

    public function create()
    {
//        $this->reset('title','body','postId');
//        $this->openModal();
        $this->reset('form.title','form.body', 'postId');
        $this->openModal();
    }
    public function store()
    {
//        $this->validate();
//        Post::create([
//            'title' => $this->title,
//            'body' => $this->body,
//        ]);
//        session()->flash('success', 'Post created successfully.');
//
//        $this->reset('title','body');
//        $this->closeModal();

        $this->validate();
        $this->form->save();
        session()->flash('success', 'Post created successfully.');
        $this->reset('form.title','form.body');
        $this->closeModal();
    }
    public function edit($id)
    {
//        $post = Post::findOrFail($id);
//        $this->postId = $id;
//        $this->title = $post->title;
//        $this->body = $post->body;
//
//        $this->openModal();
        $post = Post::findOrFail($id);
        $this->postId = $id;
        $this->form->title = $post->title;
        $this->form->body = $post->body;

        $this->openModal();
    }
    public function update()
    {
//        if ($this->postId) {
//            $post = Post::findOrFail($this->postId);
//            $post->update([
//                'title' => $this->title,
//                'body' => $this->body,
//            ]);
//            session()->flash('success', 'Post updated successfully.');
//            $this->closeModal();
//            $this->reset('title', 'body', 'postId');

        if ($this->postId) {
            $post = Post::findOrFail($this->postId);
            $post->update([
                'title' => $this->form->title,
                'body' => $this->form->body,
            ]);
            $this->postId='';
            session()->flash('success', 'Post updated successfully.');
            $this->closeModal();
            $this->reset('form.title','form.body');
        }
    }
    public function delete($id)
    {
        Post::find($id)->delete();
        session()->flash('success', 'Post deleted successfully.');
        $this->reset('title','body');
    }
    public function openModal()
    {
        $this->isOpen = true;
        $this->resetValidation();
    }
    public function closeModal()
    {
        $this->isOpen = false;
    }
    public function render()
    {
        return view('livewire.post-component',[
            'posts' => Post::paginate(5)
        ]);
    }
}
