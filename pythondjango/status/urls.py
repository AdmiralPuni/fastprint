from django.urls import path 
from . import views

# define the urls
urlpatterns = [
    path('status/', views.tasks),
    path('status/<int:pk>/', views.task_detail),
]