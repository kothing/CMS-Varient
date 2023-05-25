<?php echo view('common/_emoji_reactions_item', ['reactions' => $reactions, 'reactionVote' => $reactions->re_like, 'reaction' => 'like']);
echo view('common/_emoji_reactions_item', ['reactions' => $reactions, 'reactionVote' => $reactions->re_dislike, 'reaction' => 'dislike']);
echo view('common/_emoji_reactions_item', ['reactions' => $reactions, 'reactionVote' => $reactions->re_love, 'reaction' => 'love']);
echo view('common/_emoji_reactions_item', ['reactions' => $reactions, 'reactionVote' => $reactions->re_funny, 'reaction' => 'funny']);
echo view('common/_emoji_reactions_item', ['reactions' => $reactions, 'reactionVote' => $reactions->re_angry, 'reaction' => 'angry']);
echo view('common/_emoji_reactions_item', ['reactions' => $reactions, 'reactionVote' => $reactions->re_sad, 'reaction' => 'sad']);
echo view('common/_emoji_reactions_item', ['reactions' => $reactions, 'reactionVote' => $reactions->re_wow, 'reaction' => 'wow']); ?>