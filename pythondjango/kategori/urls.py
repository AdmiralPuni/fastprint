from django.urls import path 
from . import views

# define the urls
urlpatterns = [
    path('kategori/', views.tasks),
    path('kategori/<int:pk>/', views.task_detail),
]