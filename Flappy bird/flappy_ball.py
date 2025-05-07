import pygame
import random
import os

# Initialize pygame
pygame.init()

# Colors
WHITE = (255, 255, 255)
BLACK = (0, 0, 0)
AQUA = (0, 255, 191)
RED = (255, 0, 0)

# Display dimensions
WIDTH = 400
HEIGHT = 600

# Create the display
game_window = pygame.display.set_mode((WIDTH, HEIGHT))
pygame.display.set_caption('Flappy Bird')

# Clock to control the speed of the game
clock = pygame.time.Clock()

# Game variables
gravity = 0.5
bird_movement = 0
game_active = True
score = 0
high_score = 0

# Font styles
font_style = pygame.font.SysFont("bahnschrift", 30)
score_font = pygame.font.SysFont("comicsansms", 40)

# Bird properties
bird_x = 100
bird_y = HEIGHT // 2

# Pipe properties
pipe_width = 70
pipe_gap = 150
pipe_list = []
SPAWNPIPE = pygame.USEREVENT
pygame.time.set_timer(SPAWNPIPE, 1200)  # Spawn pipes every 1.2 seconds

# Add a list to track pipes already scored
scored_pipes = []

# Load bird images for animation
bird_frames = [
    pygame.image.load('bird1.png').convert_alpha(),
    pygame.image.load('bird2.png').convert_alpha()
    
]
# Resize bird images if necessary
bird_frames = [pygame.transform.scale(frame, (40, 30)) for frame in bird_frames]
bird_index = 0
bird_image = bird_frames[bird_index]

# Bird animation event
BIRDANIMATE = pygame.USEREVENT + 1
pygame.time.set_timer(BIRDANIMATE, 200)  # Change frame every 200ms

# Load sounds
pygame.mixer.music.load('background.mp3')  # Ensure this file exists
pygame.mixer.music.play(-1)  # Play background music on loop
flap_sound = pygame.mixer.Sound('flap.mp3')  # Ensure this file exists

# High score file
high_score_file = 'highscore.txt'
if not os.path.exists(high_score_file):
    with open(high_score_file, 'w') as f:
        f.write('0')

with open(high_score_file, 'r') as f:
    try:
        high_score = int(f.read())
    except:
        high_score = 0

# Function to display the score
def display_score():
    score_surface = score_font.render(f"Score: {score}", True, WHITE)
    score_rect = score_surface.get_rect(center=(WIDTH // 2, 50))
    game_window.blit(score_surface, score_rect)

# Function to display the high score
def display_high_score():
    high_score_surface = font_style.render(f"High Score: {high_score}", True, WHITE)
    high_score_rect = high_score_surface.get_rect(center=(WIDTH // 2, 100))
    game_window.blit(high_score_surface, high_score_rect)

# Function to create pipes
def create_pipe():
    random_pipe_pos = random.randint(200, 400)  # Random pipe height
    bottom_pipe = pygame.Rect(WIDTH, random_pipe_pos, pipe_width, HEIGHT)
    top_pipe = pygame.Rect(WIDTH, random_pipe_pos - pipe_gap - HEIGHT, pipe_width, HEIGHT)
    return bottom_pipe, top_pipe

# Function to move pipes
def move_pipes(pipes):
    for pipe in pipes:
        pipe.centerx -= 5  # Move pipes to the left
    return pipes

# Function to draw pipes
def draw_pipes(pipes):
    for pipe in pipes:
        if pipe.top < 0:  # Top pipe
            pygame.draw.rect(game_window, RED, pipe)
        else:  # Bottom pipe
            pygame.draw.rect(game_window, RED, pipe)

# Function to check collisions
def check_collision(pipes):
    bird_rect = bird_image.get_rect(center=(bird_x, bird_y))
    for pipe in pipes:
        if pipe.colliderect(bird_rect):
            return False
    if bird_y <= 0 or bird_y >= HEIGHT:  # Collision with ground or ceiling
        return False
    return True

# Main game loop
while True:
    for event in pygame.event.get():
        if event.type == pygame.QUIT:
            # Save high score before exiting
            with open(high_score_file, 'w') as f:
                f.write(str(high_score))
            pygame.quit()
            quit()
        if event.type == pygame.KEYDOWN:
            if event.key == pygame.K_SPACE and game_active:  # Flap the bird
                bird_movement = -8
                flap_sound.play()
            if event.key == pygame.K_SPACE and not game_active:  # Restart the game
                game_active = True
                pipe_list.clear()
                scored_pipes.clear()  # Reset scored pipes
                bird_y = HEIGHT // 2
                bird_movement = 0
                score = 0
        if event.type == SPAWNPIPE:  # Spawn new pipes
            pipe_list.extend(create_pipe())
        if event.type == BIRDANIMATE:
            bird_index = (bird_index + 1) % len(bird_frames)
            bird_image = bird_frames[bird_index]

    # Draw background
    game_window.fill(AQUA)

    if game_active:
        # Bird movement
        bird_movement += gravity
        bird_y += bird_movement

        # Draw bird
        game_window.blit(bird_image, bird_image.get_rect(center=(bird_x, int(bird_y))))

        # Pipes
        pipe_list = move_pipes(pipe_list)
        draw_pipes(pipe_list)

        # Check for collisions
        game_active = check_collision(pipe_list)

        # Update score
        for pipe in pipe_list:
            if pipe.centerx + pipe_width // 2 < bird_x and pipe not in scored_pipes:
                score += 1
                scored_pipes.append(pipe)  # Mark pipe as scored

        display_score()
        display_high_score()
    else:
        # Update high score if necessary
        if score > high_score:
            high_score = score
            with open(high_score_file, 'w') as f:
                f.write(str(high_score))

        # Game over screen
        game_window.fill(AQUA)
        message = font_style.render("Game Over! Press SPACE to Restart", True, BLACK)
        game_window.blit(message, (WIDTH // 6, HEIGHT // 2))
        display_score()
        display_high_score()

    pygame.display.update()
    clock.tick(60)  # 60 FPS

