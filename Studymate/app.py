from flask import Flask, render_template, redirect, url_for, request, flash
from flask_sqlalchemy import SQLAlchemy
from flask_login import LoginManager, UserMixin, login_user, login_required, logout_user, current_user

# App and DB setup
app = Flask(__name__)
app.config['SECRET_KEY'] = 'your_secret_key'
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///database.db'
db = SQLAlchemy(app)

# Flask-Login manager
login_manager = LoginManager(app)
login_manager.login_view = 'login'

# User model
class User(UserMixin, db.Model):
    id = db.Column(db.Integer, primary_key=True)
    username = db.Column(db.String(150), unique=True, nullable=False)
    password = db.Column(db.String(150), nullable=False)

# Course model
class Course(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String(200), nullable=False)
    category = db.Column(db.String(100), nullable=False)
    youtube_url = db.Column(db.String(300), nullable=False)

# Note model
class Note(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    content = db.Column(db.Text, nullable=False)

# User loader
@login_manager.user_loader
def load_user(user_id):
    return User.query.get(int(user_id))

# Home page
@app.route('/')
@login_required
def home():
    courses = Course.query.all()

    # Group courses by category
    courses_by_category = {}
    for course in courses:
        if course.category not in courses_by_category:
            courses_by_category[course.category] = []
        courses_by_category[course.category].append(course)

    notes = Note.query.all()
    return render_template('home.html', username=current_user.username, 
                           courses_by_category=courses_by_category, notes=notes)

# Register route
@app.route('/register', methods=['GET', 'POST'])
def register():
    if request.method == 'POST':
        username = request.form['username']
        password = request.form['password']
        existing_user = User.query.filter_by(username=username).first()

        if existing_user:
            flash('Username already exists. Please choose a different one.')
            return redirect(url_for('register'))

        new_user = User(username=username, password=password)
        db.session.add(new_user)
        db.session.commit()

        flash('Account created successfully. Please log in!')
        return redirect(url_for('login'))

    return render_template('register.html')

# Login route
@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        username = request.form['username']
        password = request.form['password']
        user = User.query.filter_by(username=username).first()

        if user and user.password == password:
            login_user(user)
            return redirect(url_for('home'))
        else:
            flash('Invalid credentials. Please try again.')
            return redirect(url_for('login'))

    return render_template('login.html')

# Logout
@app.route('/logout')
@login_required
def logout():
    logout_user()
    return redirect(url_for('login'))

# Add course route
@app.route('/add_course', methods=['POST'])
@login_required
def add_course():
    title = request.form['title']
    category = request.form['category']
    youtube_url = request.form['youtube_url']

    new_course = Course(title=title, category=category, youtube_url=youtube_url)
    db.session.add(new_course)
    db.session.commit()
    flash('Course added successfully!')
    return redirect(url_for('home'))

# Delete course route
@app.route('/delete_course/<int:course_id>', methods=['POST'])
@login_required
def delete_course(course_id):
    course = Course.query.get_or_404(course_id)
    db.session.delete(course)
    db.session.commit()
    flash('Course deleted successfully!')
    return redirect(url_for('home'))

# Add note route
@app.route('/add_note', methods=['POST'])
@login_required
def add_note():
    content = request.form['content']
    new_note = Note(content=content)
    db.session.add(new_note)
    db.session.commit()
    flash('Note saved!')
    return redirect(url_for('home'))

# Edit note route
@app.route('/edit_note/<int:note_id>', methods=['GET', 'POST'])
@login_required
def edit_note(note_id):
    note = Note.query.get_or_404(note_id)

    if request.method == 'POST':
        note.content = request.form['content']
        db.session.commit()
        flash('Note updated successfully!')
        return redirect(url_for('home'))

    return render_template('edit_note.html', note=note)

# Delete note route
@app.route('/delete_note/<int:note_id>', methods=['POST'])
@login_required
def delete_note(note_id):
    note = Note.query.get_or_404(note_id)
    db.session.delete(note)
    db.session.commit()
    flash('Note deleted successfully!')
    return redirect(url_for('home'))

# Create DB tables on start
if __name__ == '__main__':
    with app.app_context():
        db.create_all()
    app.run(debug=True)
