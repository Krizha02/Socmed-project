// angular.module('socialMediaApp', [])
//     .controller('PostController', function($scope, $http) {
//         $scope.posts = [];
//         $scope.newPost = {};

//         // Create a new post
//         $scope.createPost = function() {
//             $http.post('/api/posts', $scope.newPost)
//                 .then(function(response) {
//                     $scope.posts.unshift(response.data); // Add new post to the beginning of posts array
//                     $scope.newPost = {}; // Clear the form
//                 }, function(error) {
//                     alert('Error creating post: ' + error.data.message);
//                 });
//         };

//         // Fetch all posts
//         $scope.getPosts = function() {
//             $http.get('/api/posts')
//                 .then(function(response) {
//                     $scope.posts = response.data;
//                 }, function(error) {
//                     alert('Error fetching posts: ' + error.data.message);
//                 });
//         };

//          // Toggle like/unlike for a post with optimistic update
//          $scope.toggleLike = function(post) {
//             // Optimistic update
//             const wasLiked = post.user_has_liked;
//             post.user_has_liked = !wasLiked;
//             post.like_count += wasLiked ? -1 : 1;

//             $http.post('/api/posts/' + post.id + '/like')
//                 .then(function(response) {
//                     // Update with actual server response
//                     post.user_has_liked = response.data.liked;
//                     post.like_count = response.data.like_count;
//                 }, function(error) {
//                     // Revert on error
//                     post.user_has_liked = wasLiked;
//                     post.like_count = wasLiked ? post.like_count + 1 : post.like_count - 1;
//                     console.error('Error toggling like:', error);
//                 });
//         };

//           // Toggle comments visibility
//           $scope.toggleComments = function(post) {
//             post.showComments = !post.showComments;
//         };
    

//         // Add a comment to a post
//         $scope.addComment = function(post) {
//             $http.post('/api/posts/' + post.id + '/comments', { comment: post.newComment })
//                 .then(function(response) {
//                     post.comments.push(response.data); // Add the new comment to the post's comments array
//                     post.newComment = ''; // Clear the comment input
//                 }, function(error) {
//                     alert('Error adding comment: ' + error.data.message);
//                 });
//         };

//          // Delete a comment with optimistic update
//         $scope.deleteComment = function(post, comment, commentIndex) {
//             // Optimistic update - remove comment immediately
//             post.comments.splice(commentIndex, 1);

//             $http.delete('/api/posts/' + post.id + '/comments/' + comment.id)
//                 .then(function(response) {
//                     // Success case - comment already removed
//                 }, function(error) {
//                     // Revert on error
//                     post.comments.splice(commentIndex, 0, comment);
//                     console.error('Error deleting comment:', error);
//                     alert('Error deleting comment: ' + error.data.message);
//                 });
//         };

//            // Edit post
//            $scope.editPost = function(post) {
//             post.editing = true;
//             post.editContent = post.content; // Store original content in case of cancel
//         };

//         // Save edited post
//         $scope.savePost = function(post) {
//             $http.put('/api/posts/' + post.id, { content: post.content })
//                 .then(function(response) {
//                     post.content = response.data.content;
//                     post.editing = false;
//                 })
//                 .catch(function(error) {
//                     alert('Error updating post: ' + error.data.message);
//                     post.content = post.editContent; // Revert to original content
//                     post.editing = false;
//                 });
//         };

//         // Cancel editing
//         $scope.cancelEdit = function(post) {
//             post.content = post.editContent;
//             post.editing = false;
//         };

//         // Delete a post
//         $scope.deletePost = function(post) {
//             if (!confirm('Are you sure you want to delete this post?')) {
//                 return;
//             }

//             $http.delete('/api/posts/' + post.id)
//                 .then(function() {
//                     const index = $scope.posts.indexOf(post);
//                     if (index > -1) {
//                         $scope.posts.splice(index, 1);
//                     }
//                 })
//                 .catch(function(error) {
//                     alert('Error deleting post: ' + error.data.message);
//                 });
//         };

//         // Delete a comment
//         $scope.deleteComment = function(post, comment) {
//             if (!confirm('Are you sure you want to delete this comment?')) {
//                 return;
//             }

//             $http.delete('/api/posts/' + post.id + '/comments/' + comment.id)
//                 .then(function() {
//                     const index = post.comments.indexOf(comment);
//                     if (index > -1) {
//                         post.comments.splice(index, 1);
//                     }
//                 })
//                 .catch(function(error) {
//                     alert('Error deleting comment: ' + error.data.message);
//                 });
//         };
        
//         $scope.getPosts();
//     });


angular.module('socialMediaApp', [])
    .controller('PostController', function($scope, $http) {
        $scope.posts = [];
        $scope.newPost = {};

        // Create a new post
        $scope.createPost = function() {
            $http.post('/api/posts', $scope.newPost)
                .then(function(response) {
                    $scope.posts.unshift(response.data);
                    $scope.newPost = {};
                })
                .catch(function(error) {
                    alert('Error creating post: ' + error.data.message);
                });
        };

        // Fetch all posts
        $scope.getPosts = function() {
            $http.get('/api/posts')
                .then(function(response) {
                    $scope.posts = response.data;
                })
                .catch(function(error) {
                    alert('Error fetching posts: ' + error.data.message);
                });
        };

        // Toggle like/unlike for a post with optimistic update
        $scope.toggleLike = function(post) {
            const wasLiked = post.user_has_liked;
            post.user_has_liked = !wasLiked;
            post.like_count += wasLiked ? -1 : 1;

            $http.post('/api/posts/' + post.id + '/like')
                .then(function(response) {
                    post.user_has_liked = response.data.liked;
                    post.like_count = response.data.like_count;
                })
                .catch(function(error) {
                    post.user_has_liked = wasLiked;
                    post.like_count = wasLiked ? post.like_count + 1 : post.like_count - 1;
                    console.error('Error toggling like:', error);
                });
        };

        // Toggle comments visibility
        $scope.toggleComments = function(post) {
            post.showComments = !post.showComments;
        };

        // Add a comment to a post
        $scope.addComment = function(post) {
            $http.post('/api/posts/' + post.id + '/comments', { comment: post.newComment })
                .then(function(response) {
                    post.comments.push(response.data);
                    post.newComment = '';
                })
                .catch(function(error) {
                    alert('Error adding comment: ' + error.data.message);
                });
        };

        // Delete a comment with optimistic update
        $scope.deleteComment = function(post, comment) {
            const index = post.comments.indexOf(comment);
            post.comments.splice(index, 1);

            $http.delete('/api/posts/' + post.id + '/comments/' + comment.id)
                .catch(function(error) {
                    post.comments.splice(index, 0, comment);
                    console.error('Error deleting comment:', error);
                    alert('Error deleting comment: ' + error.data.message);
                });
        };

        // Edit post
        $scope.editPost = function(post) {
            post.editing = true;
            post.originalContent = post.content;
        };

        // Save edited post
        $scope.savePost = function(post) {
            $http.put('/api/posts/' + post.id, { content: post.content })
                .then(function(response) {
                    post.content = response.data.content;
                    post.editing = false;
                })
                .catch(function(error) {
                    alert('Error updating post: ' + error.data.message);
                    post.content = post.originalContent;
                    post.editing = false;
                });
        };

        // Cancel editing
        $scope.cancelEdit = function(post) {
            post.content = post.originalContent;
            post.editing = false;
        };

        // Delete a post
        $scope.deletePost = function(post) {
            // if (!confirm('Are you sure you want to delete this post?')) {
            //     return;
            // }

            $http.delete('/api/posts/' + post.id)
                .then(function() {
                    const index = $scope.posts.indexOf(post);
                    if (index > -1) {
                        $scope.posts.splice(index, 1);
                    }
                })
                .catch(function(error) {
                    alert('Error deleting post: ' + error.data.message);
                });
        };

        $scope.getPosts();
    });