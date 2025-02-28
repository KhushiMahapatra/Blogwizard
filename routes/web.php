<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\Auth\PostController;
use App\Http\Controllers\Auth\CategoryController;
use App\Http\Controllers\Auth\TagsController;
use App\Http\Controllers\Auth\BlogController;
use App\Http\Controllers\Auth\CommentController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Middleware\CheckUserAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TermController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactInfoController;
use App\Http\Controllers\Admin\PageController;
use App\Models\Page;
use App\Models\Post;
use App\Http\Controllers\ImageUploadController;



//https://www.blackbox.ai/chat/qgbDZ9n


Route::post('/upload-image', [ImageUploadController::class, 'upload'])->name('upload.image');


Route::get('/check-slug', function (\Illuminate\Http\Request $request) {
    $slug = $request->query('slug');
    $exists = Page::where('slug', $slug)->exists();
    return response()->json(['exists' => $exists]);
});





// Authentication routes
Auth::routes([
    //'register' => false
]);


// Logout route using POST method
Route::match(['get', 'post'], '/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('custom.logout'); // Use a unique name



Route::post('/pages/{id}/comment', [PageController::class, 'storePageComment'])->name('page.comment');

Route::get('/posts/{post}/comments', [CommentController::class, 'showCommentsForPost'])->name('posts.comments');


Route::get('/admin/pages/comments', [PageController::class, 'showPageComments'])->name('admin.pages.pagescomments');
Route::post('/pages/{pageId}/comments', [PageController::class, 'storeComment'])->name('post.comment');


Route::get('/admin/page-comments', [PageController::class, 'showPageComments'])->name('admin.page.comments');
Route::patch('/admin/page-comments/{id}/approve', [PageController::class, 'approvePageComment'])->name('admin.page.comments.approve');
Route::delete('/admin/page-comments/{id}', [PageController::class, 'deletePageComment'])->name('admin.page.comments.delete');
Route::post('/comment/{comment}/reply', [PageController::class, 'storeCommentReply'])->name('page.comment.reply');

Route::get('/page-comment/{comment}/edit', [PageController::class, 'editComment'])->name('page.comment.edit');
Route::put('/page-comment/{comment}', [PageController::class, 'updateComment'])->name('page.comment.update');

Route::get('/page-comment/{reply}/edit-reply', [PageController::class, 'editReply'])->name('page.comment.editReply');
Route::put('/page-comment/{reply}/update-reply', [PageController::class, 'updateReply'])->name('page.comment.updateReply');
Route::patch('/admin/page/comments/unapprove/{comment}', [PageController::class, 'unapprove'])->name('admin.page.comments.unapprove');
Route::patch('/admin/page/comments/spam/{id}', [PageController::class, 'markAsSpam'])->name('admin.page.comments.spam');
Route::get('/admin/page/comments/spam', [PageController::class, 'showSpamComments'])->name('admin.pages.pagespamcomment');
Route::patch('/admin/page/comments/unspam/{id}', [PageController::class, 'unspamComment'])->name('admin.page.comments.unspam');
Route::delete('/admin/page/comments/deleteSpam/{id}', [PageController::class, 'deleteSpamComment'])->name('admin.page.comments.deleteSpam');

Route::patch('/admin/page/{id}/disable-comments', [PageController::class, 'disableComments'])->name('admin.page.comments.disable');
Route::patch('/admin/page/{id}/enable-comments', [PageController::class, 'enableComments'])->name('admin.page.comments.enable');
Route::patch('/admin/pagess/publish/{id}', [PageController::class, 'publishNow'])->name('admin.pages.publish');

Route::get('/admin/page/comments/spamfiltered', [PageController::class, 'filterSpamComments'])->name('admin.pages.pagespamcomment');
Route::get('/admin/page-comments', [PageController::class, 'filterPageComments'])->name('admin.pages.pagescomment');

Route::get('/admin/pages/{pageId}/comments', [PageController::class, 'showCommentsForPage'])
    ->name('admin.pages.comment-page');



// web.php
Route::post('/admin/pages/upload-image', [PageController::class, 'uploadImage'])->name('admin.pages.uploadImage');

Route::middleware(['auth', 'checkUserAccess'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});

    Route::resource('auth/posts', PostController::class);

    Route::patch('/posts/{post}/toggle-comments', [PostController::class, 'toggleComments'])->name('posts.toggleComments');


    Route::get('/post/{slug}', [PostController::class, 'show'])->name('post.show');

    Route::get('categories', [CategoryController::class, 'openCategoriesPage'])->name('auth.categories');

    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');

    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');

    Route::get('tags', [TagsController::class, 'openTagsPage'])->name('auth.tags');

    Route::post('/tags', [TagsController::class, 'store'])->name('tags.store');

    Route::put('/tags/{id}', [TagsController::class, 'update'])->name('tags.update');

    Route::delete('/tags/{tag}', [TagsController::class, 'destroy'])->name('tags.delete');

    Route::get('auth/profile', [ProfileController::class, 'openProfilePage'])->name('auth.profile.index');

    Route::post('auth/profile', [ProfileController::class, 'storeProfile'])->name('auth.profile.store');

Route::patch('/comments/{id}/approve', [CommentController::class, 'approve'])->name('comments.approve');

Route::patch('/comments/unapprove/{comment}', [CommentController::class, 'unapproveComment'])->name('comments.unapprove');

Route::post('/comments/{id}/spam', [CommentController::class, 'markAsSpam'])->name('comments.spam');

Route::get('/comments/spam', [CommentController::class, 'spamComments'])->name('comments.spam.index');

Route::delete('/comments/spam/{commentId}', [CommentController::class, 'deleteSpamComment'])->name('comments.spam.delete');

Route::post('/comments/{id}/unmark-spam', [CommentController::class, 'unmarkSpam'])->name('comments.unmarkSpam');


Route::get('/comments', [CommentController::class, 'showComments'])->name('comments.index');

// Edit a comment
Route::post('/comments/edit', [CommentController::class, 'edit'])->name('comments.edit');
// Delete a comment
Route::delete('/comments/delete', [CommentController::class, 'deleteComment'])->name('comments.delete');




Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');

Route::get('/',[BlogController::class, 'index'])->name('blogs.index');

Route::get('single-blog/{slug}', [BlogController::class, 'openSingleBlog'])->name('single-blog');


Route::get('/tag/{slug}', [BlogController::class, 'tagPosts'])->name('tag.posts');

Route::get('/category/{slug}', [BlogController::class, 'categoryPosts'])->name('category.posts');

Route::get('/posts/{id}', [BlogController::class, 'tagPosts'])->name('site.single');


Route::post('post/comment/{postId}',[CommentController::class,'postComment'])->name('post.comment')->middleware('auth');

Route::post('comment/reply/{commentId}',[CommentController::class,'postCommentReply'])->name('comment.reply');


Route::post('/comment/delete', [CommentController::class, 'deleteComment'])->name('comment.delete');

Route::post('/comment/edit', [CommentController::class, 'editComment'])->name('comment.edit');

Route::post('/comment/reply/edit', [CommentController::class, 'editCommentReply'])->name('comment.reply.edit');

Route::delete('/comment/reply/delete', [CommentController::class, 'deleteCommentReply'])->name('comment.reply.delete');

Route::patch('/comments/reply/{id}/approve', [CommentController::class, 'approveReply'])->name('comment.reply.approve');


Route::get('/services', [ServiceController::class, 'index'])->name('pages.services');


Route::get('/term', [PagesController::class, 'term'])->name('pages.term');

Route::get('/faq', [PagesController::class, 'faq'])->name('pages.faq');


Route::get('/about', [AboutUsController::class, 'about'])->name('pages.about');


// Admin Routes
Route::get('/about/edit', [AboutUsController::class, 'edit'])->name('admin.about.edit');
Route::post('/about/update', [AboutUsController::class, 'update'])->name('admin.about.update');

Route::get('/admin/about/policy/edit-policy', [PagesController::class, 'editPolicy'])->name('admin.about.policy.edit_policy');
    Route::post('/admin/update-policy', [PagesController::class, 'updatePolicy'])->name('admin.policy.update');
Route::get('/policies', [PagesController::class, 'show'])->name('pages.policy');


    Route::get('/admin/edit-services', [ServiceController::class, 'edit'])->name('admin.services.edit');
    Route::post('/admin/services/update', [ServiceController::class, 'update'])->name('admin.services.update');

    Route::post('/admin/services/store', [ServiceController::class, 'store'])->name('admin.services.store');
    Route::delete('/admin/services/delete/{id}', [ServiceController::class, 'destroy'])->name('admin.services.delete');

    Route::get('/terms', [TermController::class, 'index'])->name('terms.index');


    Route::get('/terms/edit', [TermController::class, 'edit'])->name('admin.terms.edit');
    Route::post('/terms/update', [TermController::class, 'update'])->name('admin.terms.update');




Route::post('/contact/submit', [ContactController::class, 'submit'])->name('pages.contact.submit');

// Admin Route to View Messages
Route::get('/admin/contact-messages', [ContactController::class, 'index'])->name('admin.contact.contact');
Route::get('/contact', [ContactController::class, 'showContactPage'])->name('pages.contact');
Route::delete('/admin/contact/messages/{id}', [ContactController::class, 'destroy'])->name('admin.contact.delete');


Route::get('/admin/contact-info', [ContactInfoController::class, 'edit'])->name('admin.contact.edit');
Route::post('/admin/contact-info/update', [ContactInfoController::class, 'update'])->name('admin.contact.update');

Route::get('/index', [PagesController::class, 'index'])->name('admin.index');


Route::prefix('admin')->group(function () {
    Route::get('/pages', [PageController::class, 'index'])->name('admin.pages.index');
    Route::get('/pages/create', [PageController::class, 'create'])->name('admin.pages.create');
    Route::post('/page', [PageController::class, 'store'])->name('admin.pages.store');
    Route::get('/pages/{id}/edit', [PageController::class, 'edit'])->name('admin.pages.edit');
    Route::put('/pages/{id}', [PageController::class, 'update'])->name('admin.pages.update');
    Route::delete('/pages/{id}', [PageController::class, 'destroy'])->name('admin.pages.delete');
    Route::get('/pages/{id}', [PageController::class, 'show'])->name('admin.pages.show');

});

Route::get('/other-pages', [PageController::class, 'pages'])->name('site.otherpages');

Route::get('/page/{slug}', [PageController::class, 'showOtherSinglepage'])->name('site.othersinglepage');

Route::get('/admin/about', [AboutUsController::class, 'viewabout'])->name('admin.pages.viewabout');


Route::get('/admin/service', [ServiceController::class, 'viewservice'])->name('admin.pages.viewservice');

Route::get('/terms', [TermController::class, 'viewterm'])->name('admin.pages.viewterm');

Route::get('/policy', [PagesController::class, 'viewpolicy'])->name('admin.pages.viewpolicy');

Route::get('/admin/contact', [ContactController::class, 'viewcontact'])->name('admin.pages.viewcontact');

Route::get('/contact-info', [ContactController::class, 'viewContactInfo'])->name('admin.pages.viewcontactinfo');

